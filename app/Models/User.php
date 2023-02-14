<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * when you want to soft delete the record then load this facade
 */
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role', 'email', 'password', 'gender', 'active','remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
    * The attributes that should be mutated to dates.
    * when you want to soft delete this field is added in table and this will be store the date of delete
    * @var array
    */
    protected $dates = ['deleted_at'];

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
    /**
     * Get the user data as list of ids with reference of name
     */
    public static function getAllUserList()
    {
        $userLisArr = User :: orderBy('name')->get()->pluck('name','id');
        return $userLisArr;
    }

    /**
     * Get user ids
     */
    public static function getUserIds($userName = null)
    {
        $userLisArr = User :: where('name','LIKE',"%{$userName}%")->pluck('id');
        return $userLisArr;
    }
}
