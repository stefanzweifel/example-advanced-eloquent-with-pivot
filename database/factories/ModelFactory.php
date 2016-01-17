<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Endpoint::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'active' => 1
    ];
});

$factory->define(App\Field::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'slug' => $faker->word
    ];
});

$factory->define(App\Rule::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'validator_name' => $faker->word,
        'parameters' => '',
    ];
});
