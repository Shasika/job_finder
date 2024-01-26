<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id', 'logo_path', 'company_name', 'company_web', 'company_email', 'company_description', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getLogoPathAttribute()
    {
        if ($this->attributes['logo_path'] !== null) {
            return asset('storage/' . $this->attributes['logo_path']);
        }

        return null;
    }

    public function userRole()
    {
        return $this->belongsTo('App\UserRole','role_id','id');
    }
}
