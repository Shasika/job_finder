<?php

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('refresh', 'UserController@refresh');
Route::post('logout', 'UserController@logout');
Route::post('reset-password', 'UserController@resetPassword');
Route::get('get-jobs', 'JobDetailController@getJobs');
Route::get('get-job-details/{id}', 'JobDetailController@getJobDetails');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('job-create', 'JobDetailController@jobCreate');
    Route::get('get-jobs-by-user', 'JobDetailController@getAllJobsByUser');
    Route::get('get-job-by-user', 'JobDetailController@getJobDetailsByUser');
    Route::get('get-jobs-types', 'JobDetailController@getJobTypes');
    Route::delete('delete-job/{id}', 'JobDetailController@deleteJob');
    Route::post('apply-job', 'JobDetailController@applyJob');
    Route::post('apply-job', 'JobDetailController@applyJob');
    Route::get('job-apply-status/{job_id}', 'JobDetailController@jobApplyStatus');
    Route::get('get-applications-by-job/{job_id}', 'JobDetailController@jobApplicationsbyJob');
    Route::get('download-resume/{application_id}', 'JobDetailController@downloadResume');
    Route::get('get-all-users', 'UserController@getUsers');
    Route::get('user-status-change', 'UserController@userStatusChange');
});





