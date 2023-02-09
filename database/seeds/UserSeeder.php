<?php

use App\Components\Helper;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pass = bcrypt("pass@123");

        $usersData = Helper::getUsers();
        foreach ($usersData as $userDataValue) {
            User::updateOrCreate([
                'name' => $userDataValue['name'],
                'email' => $userDataValue['email'],
                'role' => $userDataValue['roles'],
                'gender' => $userDataValue['gender'],
                'password' => $pass,
                'active' => $userDataValue['active'],
                'remember_token' => $userDataValue['remember_token'],
            ]);
        }
    }
}
