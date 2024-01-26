<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $credentials = $request->only('email', 'password');

        try {
            $user = User::where(['email' => $request->get('email')])->first();

            if ($user->status === 0) {
                return response()->json(['error' => 'User is inactive. Please contact administrator'], 200);
            }
            if(!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 200);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 200);
        }

        $user = User::where(['email' => $request->only('email')])->get();
        return response()->json([compact('token'), 'user' => $user]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'company_logo' => 'nullable|required_if:selectedTab,EMPLOYER|image|mimes:jpeg,png,jpg|max:2048',
            'company_name' => 'nullable|required_if:selectedTab,EMPLOYER|string|max:255',
            'company_web' => 'nullable|required_if:selectedTab,EMPLOYER|string|max:255',
            'company_email' => 'nullable|required_if:selectedTab,EMPLOYER|email|max:255',
            'company_description' => 'nullable|required_if:selectedTab,EMPLOYER|string|max:255',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        if ($request->get('selectedTab') === 'EMPLOYER') {
            $logoPath = $request->file('company_logo')->store('uploads/company_logos', 'public');
            $data = [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role_id' => 2,
                'logo_path' => $logoPath,
                'company_name' => $request->get('company_name'),
                'company_web' => $request->get('company_web'),
                'company_email' => $request->get('company_email'),
                'company_description' => $request->get('company_description'),
            ];
        } else {
            $data = [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role_id' => 3,
            ];
        }


        $user = User::create($data);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function refresh()
    {
        if ($token = auth('api')->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }

        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    public function resetPassword(Request $request)
    {
        $newPassword = $request->get('password');
        $newPassword = Hash::make($newPassword);

        $reset=DB::table('users')
            ->where("email",$request->get('email'))
            ->update(array(
                'password' => $newPassword
            ));

        return response()->json($reset, 200);

    }

    public function getUsers()
    {
        $users = [];
        $userRole = auth()->user()->role_id;
        if ($userRole === 1) {
            $users = User::select('id', 'name', 'email', 'company_name', 'company_name', 'company_web', 'company_email', 'role_id', 'status')
                ->where('role_id', '!=', 1)
                ->with(['userRole'])->get();
        }

        return $this->apiResponse($users, 200, true, 'Successfully retrieved');
    }

    public function userStatusChange(Request $request)
    {
        $requestParams = $this->removeTokenFromRequestData($request->all());
        if (isset($requestParams['user_id']) && isset($requestParams['status'])) {
            User::where('id', json_decode($requestParams['user_id']))->update(['status' => json_decode($requestParams['status'])]);
        }

        return $this->apiResponse([], 200, true, 'Successfully updated');
    }
}
