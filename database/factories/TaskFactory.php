<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Task;
use Faker\Generator as Faker;
use App\User;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create();
        },
        'body' => $faker->sentence()
    ];
});
