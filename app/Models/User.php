<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\SoftDeletes;


use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'birthdate',
        'role',
        'phone_number',
        'image',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];




    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public $incrementing = false;

    public function angkot_user()
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }

    public function angkot_supir()
    {
        return $this->hasMany(Vehicle::class, 'supir_id');
    }

    public function feedback_app_user()
    {
        return $this->hasMany(FeedbackApp::class, 'user_id');
    }

    public function perjalanan_penumpang()
    {
        return $this->hasMany(Trip::class, 'penumpang_id');
    }

    public function perjalanan_supir()
    {
        return $this->hasMany(Trip::class, 'supir_id');
    }

    public function history()
    {
        return $this->hasMany(History::class, 'user_id');
    }

    public function list_supir()
    {
        return $this->hasMany(ListDriver::class, 'supir_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorites::class, 'user_id');
    }

    public function feedback_app_owner()
    {
        return $this->hasMany(Favorites::class, 'user_id');
    }

    public function premium()
    {
        return $this->hasMany(PremiumUser::class, 'user_id');
    }
}
