<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'subject',
        'description',
        'requirements',
        'education_and_experience',
        'location',
        'vacancy_count',
        'salary',
        'vacancy_end_date',
        'salary_currency',
        'created_by',
        'job_type',
    ];

    public function createdUser()
    {
        return $this->belongsTo('App\User','created_by','id');
    }

    public function jobType()
    {
        return $this->belongsTo('App\JobType','job_type','id');
    }

    public function applications()
    {
        return $this->hasMany('App\JobApplication','job_id','id');
    }
}
