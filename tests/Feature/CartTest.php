<?php

namespace Tests\Feature;

use App\Category;
use App\Product;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ValidationCreateTrait;
use Tests\ValidationTrait;

class CategoryTest extends TestCase
{
	use RefreshDatabase;
	
	
	
	public function testUserCanAddProductInCart()
	{
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 1, 'price' => 100];
		
		$response = $this->post('/cart/add/', ['product' => $product_data]);
		$response->assertStatus(200);
		
		$response->assertSessionHas(['cart' => ['products' => [$product_data]]]);
	}
	
	
	public function testUserCanAddTwoProductInCart()
	{
		// добавление первого товара
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 1, 'price' => 100];
		
		$response = $this->post('/cart/add/', ['product' => $product_data]);
		$response->assertStatus(200);
		$response->assertSessionHas(['cart' => ['products' => [$product_data]]]);
		
		// добавление второго товара
		$product2 = factory(Product::class)->create();
		$product_data2 = ['id' => $product2->id, 'count' => 1, 'price' => 1000];
		
		$response = $this->post('/cart/add/', ['product' => $product_data2]);
		$response->assertStatus(200);
		$response->assertSessionHas(['cart' => ['products' => [$product_data, $product_data2]]]);
	}
	
	
	public function testUserCanRemoveProductInCart()
	{
		// добавление первого товара
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 3, 'price' => 100];
		
		$response = $this->post('/cart/add/', ['product' => $product_data]);
		$response->assertStatus(200);
		$response->assertSessionHas(['cart' => ['products' => [['id' => $product->id, 'count' => 3, 'price' => 100]]]]);
		
		$product_data_remove = ['id' => $product->id, 'count' => 2, 'price' => 100];
		$response = $this->post('/cart/remove/', ['product' => $product_data_remove]);
		$response->assertStatus(200);
		$response->assertSessionHas(['cart' => ['products' => [['id' => $product->id, 'count' => 1, 'price' => 100]]]]);
	}
	
}
