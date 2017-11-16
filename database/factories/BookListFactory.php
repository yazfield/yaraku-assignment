<?php

use Faker\Generator as Faker;

$factory->define(App\Models\BookList::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
    ];
});
