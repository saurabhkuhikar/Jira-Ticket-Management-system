<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Components\Helper;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$gender = Helper :: genderArr();
$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt("123456"),
        'role' => array_rand(['SUB_ADMIN'=>'SUB_ADMIN','DEV'=>'DEV','QA'=>'QA','CLIENT'=>'CLIENT']),
        'gender' => array_rand(['1'=>1,'2'=>2]),
        'active' => '1',
        'remember_token' => Str::random(20),
    ];
});
