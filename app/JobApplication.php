<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'job_id',
        'user_id',
        'candidate_name',
        'candidate_email',
        'resume_file'
    ];

    public function getLogoPathAttribute()
    {
        return asset('storage/' . $this->attributes['resume_file']);
    }
}
