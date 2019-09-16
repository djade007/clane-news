<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\User;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'content' => $faker->paragraph(10, true),
        'user_id' => factory(User::class)->create()->id
    ];
});
