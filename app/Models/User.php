<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'roles', 'email', 'password', 'gender', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getAllUserData()
    {
       return User::where(['active',1]);
    }

    /**
     * This function is use to create the new user
     * @param Array
     * @return bool
     */
    public static function saveUser($dataArr = [])
    {
        if (!User::create($dataArr)) {
           return false;
        }
        return true;
    }

    /**
     * Get the user data as list of ids with reference of name
     */
    public static function getUserList($role = "")
    {
        $userLisArr = User :: where([['active',1],['role',$role]])->orderBy('name')->get()->pluck('email','id');
        return $userLisArr;
    }
}
