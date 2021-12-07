<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'contact',
        'gst',
        'cin',
        'fssai',
        'username',
        'address_line_1',
        'address_line_2',
        'state',
        'pincode',
        'role',
    ];

    public function isAdmin()
{
    if($this->role === 1)
    { 
        return true; 
    } 
    else 
    { 
        return false; 
    }
}

public function status()
{
    if($this->status === 1)
    { 
        return true; 
    } 
    else 
    { 
        return redirect('login');
    }
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
