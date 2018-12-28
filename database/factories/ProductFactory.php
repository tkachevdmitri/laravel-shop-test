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
        'price' => $faker->randomDigit,
		'article' => '7963456',
		'brand' => 'Adidas',
		'description' => 'Описание товара',
		'category_id' => 1
    ];
});


