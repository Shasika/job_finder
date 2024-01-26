<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Handle API response type
     *
     * @param array $response
     * @param int $status_code
     * @param bool $status
     * @param string $msg
     * @return ResponseFactory|Response
     */
    public function apiResponse($response = [], $status_code = 200, $status = false, $msg = '')
    {
        return response(['data' => $response, 'status' => $status, 'msg' => $msg], $status_code)->header('Content-Type', 'application/json');
    }

    /**
     * Alter request data
     *
     * @param $request
     * @return mixed
     */
    public function removeTokenFromRequestData($request, $isCleanInputEnable = true)
    {
        unset($request['token']);
        if (isset($request['g_recaptcha'])) {
            unset($request['g_recaptcha']);
        }
        foreach ($request as $key => $item) {
            if (!is_array($item)) {
                $val = trim($item);
                if ($isCleanInputEnable == true) {
                    $val = $this->_cleanInput($val);
                }
                $request[$key] = $val;
            }
        }
        return $request;
    }

    public function _cleanInput($string)
    {
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = str_replace("’", '&apos;', $string);
        $string = str_replace("`", '&apos;', $string);
        $string = str_replace("'", '&apos;', $string);
        $string = str_replace("<", '&lt;', $string);
        $string = str_replace(">", '&gt;', $string);
        //$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
}
