<?php

declare(strict_types=1);

/* @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use OrderService\User;

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

$factory->define(User::class, static function (Faker $faker) {
    return [
        'id' => $faker->uuid,
    ];
});
