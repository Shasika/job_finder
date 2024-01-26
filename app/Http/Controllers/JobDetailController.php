<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobDetail;
use App\JobApplication;
use App\JobDetail;
use App\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

//use Tymon\JWTAuth\Facades\JWTAuth;

class JobDetailController extends Controller
{
    public function jobCreate(StoreJobDetail $request)
    {
        $requestParams = $this->removeTokenFromRequestData($request->all());
        $requestParams['description'] = html_entity_decode($requestParams['description']);
        $requestParams['requirements'] = html_entity_decode($requestParams['requirements']);
        $requestParams['education_and_experience'] = html_entity_decode($requestParams['education_and_experience']);

        if (!empty(json_decode($requestParams['job_id']))) {
            //update request
            $jobID = $requestParams['job_id'];
            unset($requestParams['job_id']);
            $jobDetails = JobDetail::where('id', $jobID)->update($requestParams);
            $successMsg = 'Successfully updated';
        } else {
            //create request
            $requestParams['created_by'] = auth()->user()->id;
            $jobDetails = JobDetail::create($requestParams);
            $successMsg = 'Successfully created';
        }

        return $this->apiResponse($jobDetails, 200, true, $successMsg);
    }

    public function getJobs(Request $request)
    {
        $requestParams = $this->removeTokenFromRequestData($request->all());
        $allJobs = $this->_getAllJobs($requestParams);

        return $this->apiResponse($allJobs, 200, true, 'Successfully retrieved');
    }

    public function getJobDetails($jobId = null)
    {
        $jobDetails = [];
        if ($jobId) {
            $jobDetails = JobDetail::where('id', $jobId)->with(['createdUser', 'jobType'])->first();
        }

        return $this->apiResponse($jobDetails, 200, true, 'Successfully retrieved');
    }

    public function getAllJobsByUser(Request $request)
    {
        $user = auth()->user();
        $allJobs = $this->_getAllJobs([], $user);
        return $this->apiResponse($allJobs, 200, true, 'Successfully retrieved');
    }

    private function _getAllJobs($requestParams, $user = null)
    {
        $searchText = null;
        if (isset($requestParams['search_text']) && !empty($requestParams['search_text'])) {
            $searchText = $requestParams['search_text'];
        }
        $getAllJobsQuery = JobDetail::query();

        if ($searchText) {
            $getAllJobsQuery = $getAllJobsQuery->where('subject', 'like', '%' . $searchText . '%');
        }

        if ($user && $user->role_id !== 1) {
            $getAllJobsQuery = $getAllJobsQuery->where('created_by', $user->id);
        }

        return $getAllJobsQuery->with(['createdUser', 'jobType', 'applications'])->get();
    }

    public function getJobTypes()
    {
        $jobTypes = JobType::select('id', 'job_type')->get();
        return $this->apiResponse($jobTypes, 200, true, 'Successfully retrieved');
    }

    public function deleteJob($id)
    {
        $job = JobDetail::find($id);

        if ($job) {
            $job->delete();
        }
    }

    public function applyJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'candidate_name' => 'required|string|max:255',
            'candidate_email' => 'required|string|email|max:255',
            'resume_file' => 'required|mimes:pdf,doc,docx|max:2048',
            'job_id' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $requestParams = $this->removeTokenFromRequestData($request->all());
        $resumePath = $request->file('resume_file')->store('uploads/resume_files', 'public');
        $userId = auth()->user()->id;
        $data = [
            'job_id' => $requestParams['job_id'],
            'user_id' => $userId,
            'candidate_name' => $requestParams['candidate_name'],
            'candidate_email' => $requestParams['candidate_email'],
            'resume_file' => $resumePath,
        ];

        $jobApplication = JobApplication::create($data);
        return $this->apiResponse($jobApplication, 200, true, 'Successfully created');
    }

    public function jobApplyStatus($jobId)
    {
        $alreadyApplied = false;
        $jobId = json_decode($jobId);
        $userId = auth()->user()->id;
        if ($jobId) {
            $jobApplication = JobApplication::where(['job_id' => $jobId, 'user_id' => $userId])->first();
            $alreadyApplied = $jobApplication ? true : false;
        }

        return $this->apiResponse($alreadyApplied, 200, true, 'Successfully retrieved');
    }

    public function jobApplicationsbyJob($jobId)
    {
        $userId = auth()->user()->id;
        $applications = JobApplication::where(['job_id' => $jobId])->get();
        return $this->apiResponse($applications, 200, true, 'Successfully retrieved');
    }

    public function downloadResume($applicationId)
    {
        $resumeFile = null;
        $jobApplication = JobApplication::where(['id' => $applicationId])->first();

        if ($jobApplication) {
            $resumeFile = $jobApplication->resume_file;
            $path = storage_path("app/public/{$resumeFile}");
            $headers = [
                'Content-Type' => '',
            ];
            return response()->download($path,'test', $headers);
        }
    }
}
