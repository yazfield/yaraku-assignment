<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'author_id' => function () {
            return factory(App\Models\Author::class)->create()->id;
        },
    ];
});
