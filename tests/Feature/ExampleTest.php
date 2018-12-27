<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    // запуск тестов php vendor\phpunit\phpunit\phpunit
    
	// тестируем ответ главной страницы
	public function testHomePageStatus()
	{
		$response = $this->get('/');
		$response->assertStatus(200);
		$response->assertViewIs('pages.index');
	}
	
	
	
	// ADMIN TESTS
	public function testAdminPageStatus()
	{
		$response = $this->get('/admin');
		$response->assertStatus(200);
		$response->assertViewIs('admin.index');
	}
    // тестируем добавление товара
    public function testAdminCreateProductTest()
    {
    	$data = [
    		'title' => 'Тест',
			'price' => '2020'
		];
        $response = $this->post('/admin/products/create', $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', $data);
    }
    
    // тестируем отображение товаров
	/*
    public function testShowCatalogProducts()
	{
		factory(\App\Product::class)->create(['title' => 'товар 1', 'price' => '120']);
		factory(\App\Product::class)->create(['title' => 'товар 2', 'price' => '200']);
		
		$response = $this->get('/catalog');
		
		$response->assertViewIs('catalog');
		$response->assertSeeTextInOrder(['товар 1', 'товар 2']);
	}
	*/
 
}
