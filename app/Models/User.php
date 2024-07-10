<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    ###############################################################################
    ##Relationships################################################################
    ###############################################################################

    public function user_access_token(){
        return $this->hasOne(UserAccessToken::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }   
}
