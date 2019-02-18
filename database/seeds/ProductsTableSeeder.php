<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//		factory(\App\Product::class, 10)->create()->each(function ($product) {
//			$product->category()->save(factory(App\Category::class)->make());
//		});
	
		factory(\App\Product::class, 10)->create();
    }
}
