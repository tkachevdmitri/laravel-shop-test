<?php

namespace Tests\Feature;

use App\Category;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
	use RefreshDatabase;
	
	// запуск тестов в консоли php vendor\phpunit\phpunit\phpunit
	
	// ТОВАР (данные и методы)
	// массив с данными товара
	public function productData()
	{
		$data = [
			'title' => 'Товар',
			'price' => '2020',
			'article' => '7963456',
			'brand' => 'Adidas',
			'description' => 'Описание товара',
		];
		$data['category_id'] = $this->productCategory();
		
		return $data;
	}
	// запрос для манипуляции с товарами
	public function productRequest($data)
	{
		return $this->post('/admin/products', $data);
	}
	// категория товара для массива с данными
	public function productCategory()
	{
		return Category::create(['title' => 'Test'])->id;
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
	
	
    // Товар (создание нового)
	/*
	 * Тест: создание товара из админки (проверяет что  товар существует в БД)
	 */
    public function testAdminCanCreateProductTest()
    {
		$data = $this->productData();
		
    	$response = $this->productRequest($data); // post запрос на /categories пойдет на роут products.store
        $response->assertStatus(302);
        $this->assertDatabaseHas('products', $data);
    }
    
	/*
	 * Тест: создание товара из админки, с пустым названием (проверяет что  товар не существует в БД)
	 */
    public function testAdminNotCanCreateProductNotTitle()
	{
		
		$data = $this->productData();
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
		$data = $this->productData();
		
		$response = $this->productRequest($data);
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertCount(1, Product::all());
	}
	
	/*
	 * Тест: создание товара из админки, с пустой ценой (проверяет что  товар не существует в БД)
	 */
	public function testAdminNotCanCreateProductNotPrice()
	{
		$data = $this->productData();
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
		$data = $this->productData();
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
		$data = $this->productData();
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
		$data = $this->productData();
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
		$data = $this->productData();
		$data['price'] = -5;
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с категорией которой не существует (проверяет что  товар не существует в БД)
	 */
	public function testAdminNotCanCreateProductMissingCategory()
	{
		
		$data = $this->productData();
		$data['category_id'] = 20;
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с пустым артикулом (проверяет что  товар не существует в БД)
	 */
	public function testAdminNotCanCreateProductNotArticle()
	{
		
		$data = $this->productData();
		$data['article'] = '';
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с одинаковыми артикулмаи (проверяет что  товар создается в БД с уникальным артикулом)
	 */
	public function testAdminNotCanCreateProductNotUniqueArticle()
	{
		$data = $this->productData();
		$data['article'] = '222';
		
		$response = $this->productRequest($data);
		$response = $this->productRequest($data);
		
		$response->assertStatus(302);
		$this->assertCount(1, Product::all());
	}
	
	/*
	 * Тест: создание товара из админки, с пустым брендом (проверяет что  товар не существует в БД)
	 */
	public function testAdminNotCanCreateProductNotBrand()
	{
		$data = $this->productData();
		$data['brand'] = '';
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с пустым чекбоксом "Новый" (проверяет что  товар существует в БД)
	 */
	public function testAdminCanCreateProductEmptyNew()
	{
		$data = $this->productData();
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseHas('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с нажатым чекбоксом "Новый" (проверяет что  товар существует в БД)
	 */
	public function testAdminCanCreateProductCheckedNew()
	{
		$data = $this->productData();
		$data['is_new'] = 1;
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseHas('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, для value передается что то не понятно (проверяет что  товар не существует в БД)
	 */
	public function testAdminCanCreateProductCheckedChangeValuedNew()
	{
		$data = $this->productData();
		$data['is_new'] = 'sdasd';
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с пустым чекбоксом "Рекомендуемый" (проверяет что  товар существует в БД)
	 */
	public function testAdminCanCreateProductEmptyRecommended()
	{
		$data = $this->productData();
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseHas('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с нажатым чекбоксом "Рекомендуемый" (проверяет что  товар существует в БД)
	 */
	public function testAdminCanCreateProductCheckedRecommended()
	{
		$data = $this->productData();
		$data['is_recommended'] = 1;
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseHas('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, для value передается что то не понятно (проверяет что  товар не существует в БД)
	 */
	public function testAdminCanCreateProductCheckedChangeValuedRecommended()
	{
		$data = $this->productData();
		$data['is_recommended'] = 'sdasd';
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	// Товар (удаление)
	public function testAdminRemoveProduct()
	{
		$product = Product::create($this->productData());
		//$product = factory(Product::class)->create();
		if($this->assertDatabaseHas('products', ['id' => $product->id])){
			$response = $this->call('DELETE', 'admin/products/'.$product->id);
			//$response->assertStatus(302);
			$this->assertDatabaseMissing('products', ['id' => $product->id]);
		}
	}
	
	
	
	// Категория
	/*
	 * Тест: создание категории из админки (проверяет что  товар существует в БД)
	 */
	public function testAdminCanCreateCategory()
	{
		$data = ['title' => 'Категория'];
		
		$response = $this->post('/admin/categories', $data); // post запрос на /categories пойдет на роут categories.store
		$response->assertStatus(302);
		$this->assertDatabaseHas('categories', $data);
	}
	
	/*
	 * Тест: создание категории из админки, с пустым названием (проверяет что  товар не существует в БД)
	 */
	public function testAdminCanCreateCategoryNotTitle()
	{
		$data = ['title' => ''];
		
		$response = $this->post('/admin/categories', $data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('categories', $data);
	}
	
	/*
	 * Тест: создание категории из админки, проверка на уникальность категории, создается 2 одинаковых категории (проверяет что  кол-во категории в БД == 1)
	 */
	public function testAdminCanCreateCategoryNotUnique()
	{
		$data = ['title' => 'Категория'];
		
		$response = $this->post('/admin/categories', $data);
		$response = $this->post('/admin/categories', $data);
		$response->assertStatus(302);
		$this->assertCount(1, Category::all());
	}
	
	// Категория (удаление)
	public function testAdminRemoveCategory()
	{
		$category = Category::create(['title' => 'Категория']);
		if($this->assertDatabaseHas('categories', ['id' => $category->id])){
			$response = $this->call('DELETE', 'admin/categories/'.$category->id);
			//$response->assertStatus(302);
			$this->assertDatabaseMissing('categories', ['id' => $category->id]);
		}
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
