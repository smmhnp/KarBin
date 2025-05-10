<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    
    public function getJWTIdentifier(){
        return $this->getKey();
    }
    
    public function getJWTCustomClaims(){
        return [];
    }

    protected $fillable = [
        'firstname', 'lastname', 'nickname', 'role', 'unit', 'email', 'password'
    ];
    


    protected $hidden = [
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}