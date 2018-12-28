<?php

namespace Tests\Feature;

use App\Category;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
	use RefreshDatabase;
	
	// запуск тестов php vendor\phpunit\phpunit\phpunit
	
	// ТОВАР (данные и методы)
	public $data = [
		'title' => 'Товар',
		'price' => '2020',
		'article' => '7963456',
		'brand' => 'Adidas',
		'description' => 'Описание товара',
		'category_id' => 1,
	];
	
	public function productRequest($data)
	{
		return $this->post('/admin/products', $data);
	}


	
	// FRONT TESTS
	// тестируем ответ главной страницы
	public function testHomePageStatus()
	{
		$response = $this->get('/');
		$response->assertStatus(200);
		$response->assertViewIs('pages.index');
	}
	// тестируем ответ страницы категория (конкретная категория)
	/*
	public function testCategoryPageStatus()
	{
		$response = $this->get('/category/1');
		$response->assertStatus(200);
		$response->assertViewIs('pages.category');
	}
	*/
	
	
	// ADMIN TESTS
	// статусы страниц
	public function testAdminPageStatus()
	{
		$response = $this->get('/admin');
		$response->assertStatus(200);
		$response->assertViewIs('admin.index');
	}
	public function testAdminPageProductsStatus()
	{
		$response = $this->get('/admin/products');
		$response->assertStatus(200);
		$response->assertViewIs('admin.products.index');
	}
	public function testAdminPageCategoriesStatus()
	{
		$response = $this->get('/admin/categories');
		$response->assertStatus(200);
		$response->assertViewIs('admin.categories.index');
	}
	
	
    // Товар
	/*
	 * Тест: создание товара из админки (проверяет что  товар существует в БД)
	 */
    public function testAdminCanCreateProductTest()
    {
    	$response = $this->productRequest($this->data); // post запрос на /categories пойдет на роут products.store
        $response->assertStatus(302);
        $this->assertDatabaseHas('products', $this->data);
    }
	
	/*
	 * Тест: создание товара из админки, с пустым названием (проверяет что  товар не существует в БД)
	 */
    public function testAdminNotCanCreateProductNotTitle()
	{
		
		$data = $this->data;
		$data['title'] = '';
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, проверка на уникальность товара, создается 2 одинаковых товара (проверяет что  кол-во товаров в БД == 1)
	 */
	public function testAdminNotCanCreateProductNotUnique()
	{
		$response = $this->productRequest($this->data);
		$response = $this->productRequest($this->data);
		$response->assertStatus(302);
		$this->assertCount(1, Product::all());
	}
	
	/*
	 * Тест: создание товара из админки, с пустой ценой (проверяет что  товар не существует в БД)
	 */
	public function testAdminNotCanCreateProductNotPrice()
	{
		$data = $this->data;
		$data['price'] = '';
		
		$response = $this->productRequest($data);
		//file_put_contents(storage_path().'/dump.txt', $response->getContent());
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с ценой, целое число (проверяет что  товар существует в БД)
	 */
	public function testAdminNotCanCreateProductNumberPrice()
	{
		$data = $this->data;
		$data['price'] = 10;
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseHas('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с ценой, число с плавающей точкой (проверяет что  товар существует в БД)
	 */
	public function testAdminNotCanCreateProductNumberFloatPrice()
	{
		$data = $this->data;
		$data['price'] = 10.50;
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseHas('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с ценой, число с запятой (проверяет что  товар не существует в БД)
	 */
	public function testAdminNotCanCreateProductNumberComaPrice()
	{
		$data = $this->data;
		$data['price'] = '10,50';
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с ценой меньше нуля (проверяет что  товар не существует в БД)
	 */
	public function testAdminNotCanCreateProductLessZeroPrice()
	{
		$data = $this->data;
		$data['price'] = -5;
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
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
	
	
	// Категории товаров
	/*
	public function testAdminCreateCategoriesTest()
	{
		$data = [
			'title' => 'Тест',
		];
		$response = $this->post('/admin/categories', $data);  // post запрос на /categories пойдет на роут categories.store
		
		//$response->assertStatus(200);
		$this->assertDatabaseHas('categories', $data);
	}
	*/
 
}
