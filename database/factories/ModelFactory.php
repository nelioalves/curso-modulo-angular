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

$factory->define(CodeProject\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(CodeProject\Entities\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});


$factory->define(CodeProject\Entities\Project::class, function (Faker\Generator $faker) {
    return [
        'owner_id' => rand(2,10),
        'client_id' => rand(1,10),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'progress' => rand(1,100),
        'status' => rand(1,3),
        'due_date' => rand(1,28)."/".rand(1,12)."/".rand(2010,2013),
    ];
});

$factory->define(CodeProject\Entities\ProjectTask::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence,
        'project_id' => rand(1,10),
        'start_date' => rand(1,28)."/".rand(1,12)."/".rand(2014,2015),
        'due_date' => rand(1,28)."/".rand(1,12)."/".rand(2016,2016),
        'status' => rand(1,3),
    ];
});

$factory->define(CodeProject\Entities\ProjectNote::class, function (Faker\Generator $faker) {
    return [
        'project_id' => rand(1,10),
        'title' => $faker->word,
        'content' => $faker->paragraph,
    ];
});


$factory->define(CodeProject\Entities\ProjectMember::class, function (Faker\Generator $faker) {
    return [
        'project_id' => rand(1,10),
        'user_id' => rand(1,10),
    ];
});

$factory->define(CodeProject\Entities\OauthClient::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->word,
        'name' => $faker->word,
        'secret' => $faker->word,
    ];
});
