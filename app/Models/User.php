<?php

namespace App\Models;


// namespace App\Models;

// use Illuminate\Auth\Authenticatable;
// use Tymon\JWTAuth\Contracts\JWTSubject;
// use Illuminate\Database\Eloquent\Model;


// class User extends Model implements JWTSubject
// {
//     use Authenticatable;

//     protected $fillable = ['name', 'email', 'password'];

//     // Implement JWTSubject methods

//     // Return the identifier for JWT (usually user ID)
//     public function getJWTIdentifier()
//     {
//         return $this->getKey();
//     }

//     // Return key-value array with custom JWT claims
//     public function getJWTCustomClaims()
//     {
//         return [];
//     }
// }

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;
    protected $fillable = ['name', 'email', 'password'];

    // Implement JWTSubject methods

    // Return the identifier for JWT (usually user ID)
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Return key-value array with custom JWT claims
    public function getJWTCustomClaims()
    { 
        return [];
    }
}