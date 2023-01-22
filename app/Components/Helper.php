<?php
namespace App\Components;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class Helper
{

    /**
     * This function is use to return gender array
     * @return gender
     */
    public function genderArr()
    {
        return ['1' => 'Male', '2' => 'Female'];
    }
    /**
     * This function is use to return the active status arry
     * @return array
     */
    public static function getStatusArr()
    {
        return ['0' => 'Deactive', '1' => 'Active'];
    }
    /**
     * getItemEthnicityOptions
     *
     * @return array
     */
    public static function getUsers()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'gender' => 1,
                'roles'=>'ADMIN',
                'active' => 1,
                'remember_token' => Str::random(20),
            ],
            [
                'name' => 'Saurabh kuhikar',
                'email' => 'saurabh@gmail.com',
                'roles'=>'SUB_ADMIN',
                'gender' => 1,
                'active' => 1,
                'remember_token' => Str::random(20),
            ],
            [
                'name' => 'nandini kose',
                'email' => 'nandini@gmail.com',
                'roles'=>'SUB_ADMIN',
                'gender' => 2,
                'active' => 1,
                'remember_token' => Str::random(20),
            ],
        ];

        return $users;
    }

    /**
     * sent the mail
     * @param array
     * @return bool
     */
    public static function sentMails($sentMailArr = [])
    {
        // $email = $sentMailArr['email'];
        // Mail::to($email)->send(new ContactMail($sentMailArr));
        // // check for failed ones
        // if (Mail::failures()) {
        //     // return failed mails
        //     return false;
        // }
        // return true;
    }
}
