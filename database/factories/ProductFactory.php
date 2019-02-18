<?php

use Faker\Generator as Faker;

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

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'price' => $faker->numberBetween(500, 15000),
		'category_id' => $faker->numberBetween(1, 5),  // так как создаю 5 категорий
		'article' => $faker->unique()->randomDigit,
		'brand' => $faker->word,
		'description' => $faker->sentence,
		'is_new' => $faker->numberBetween(0, 1),
		'is_recommended' => $faker->numberBetween(0, 1),
		'status' => 1,
		'image' => 'tovar.jpg',
    ];
});


