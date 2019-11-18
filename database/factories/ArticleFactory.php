<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'cid' => mt_rand(2,5),
        'title' => $faker->sentence(),
        'desn' => $faker->sentence(),
        'pic' =>  '/uploads/articles/8lTlngQeZkmed6AUi5QZmrLFcz7w4s8uxEaP0q9F.jpeg',
        'body' => $faker->text()
    ];
});
