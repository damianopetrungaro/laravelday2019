<?php

declare(strict_types=1);

/* @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use OrderService\Book;

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

$factory->define(Book::class, static function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'title' => $faker->sentence,
        'author' => $faker->name,
        'price' => $faker->numberBetween(1000, 10000),
    ];
});
