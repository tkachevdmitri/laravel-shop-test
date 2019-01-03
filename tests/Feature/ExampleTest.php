<?php

namespace Tests\Feature;

use App\Category;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ValidationCreateTrait;
use Tests\ValidationTrait;

class ExampleTest extends TestCase
{
	use RefreshDatabase;
	
	use ValidationTrait;
	
	use ValidationCreateTrait;
	
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
	
	public function testAdminCantCreateProductRequiredValidation()
	{
		$data = $this->productData();
		//$product = factory(Product::class)->create()->toArray();
		//$category = Category::create(['title' => 'Test']);
		
		$arr = ['title' => '', 'article' => '', 'brand' => '', 'price' => '', 'category_id' => ''];
		$input = array_merge($data, $arr);
		
		//$this->assertCantCreateProduct($input);
	}
	
	public function testAdminCantCreateProductNumericValidation()
	{
		$arr = ['price' => 50];
		$data = $this->productData();
		$input = array_merge($data, $arr);
		
		$this->assertCantCreate($input, ['price']);
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
	
	
	
	// Товар (обновление)
	private function assertCantUpdateProduct($product, $fields, $arr)
	{
		$data = array_merge($product->toArray(), $arr);
		$this->assertCantUpdate(
			'products',
			'admin/products/'.$product->id,
			$product->toArray(),
			$fields,
			$data
		);
	}
	
	/**
	 * Тест: обновление товара из админки
	 */
	public function  testAdminUpdateProductName()
	{
		$input = $this->productData();
		$product = factory(Product::class)->create($input);
		$category = factory(Category::class)->create();

		$data = [
			'id' => ''.$product->id,
			'title' => 'new name',
			'price' => '456',
			'article' => '123456',
			'brand' => 'Brand',
			'description' => 'Описание',
			'category_id' => $category->id
		];
		
		$this->assertDatabaseHas('products', array_merge(['id' => ''.$product->id], $input));
		$response = $this->call('PUT', 'admin/products/'.$product->id, $data);
		$this->assertDatabaseHas('products', $data);
		$response->assertStatus(302);
	}
	
	
	/**
	 * Тест: обновление товара, проверка обязательных полей
	 */
	public function  testAdminUpdateProductRequiredValidation()
	{
		$arr = ['title' => '', 'price' => '', 'article' => '', 'brand' => '', 'category_id' => ''];
		$product = factory(Product::class)->create();
		
		
		//$this->assertCantUpdate($product, ['title', 'price', 'article', 'category_id', 'brand'], $data);
		$this->assertCantUpdateProduct(
			$product,
			['title', 'price', 'article', 'category_id', 'brand'],
			$arr
		);
	}
	
	/**
	 * Тест: обновление товара, проверка уникальных полей
	 */
	public function  testAdminUpdateProductUniqueValidation()
	{
		$arr = ['title' => 'Tovar 1', 'article' => 'Article 1'];
		$product1 = factory(Product::class)->create($arr);
		$product2 = factory(Product::class)->create();
		
		
		//$this->assertCantUpdate($product2, ['title', 'article'], $data);
		$this->assertCantUpdateProduct(
			$product2,
			['title', 'article'],
			$arr
		);
	}
	
	/**
	 * Тест: обновление товара, проверка numeric полей
	 */
	public function  testAdminUpdateProductNumericValidation()
	{
		$arr = ['price' => 'asdasdsa'];
		$product1 = factory(Product::class)->create();
		
		//$this->assertCantUpdate($product1, ['price'], $data);
		$this->assertCantUpdateProduct(
			$product1,
			['price'],
			$arr
		);
	}
	
	/**
	 * Тест: обновление товара, проверка min полей
	 */
	public function  testAdminUpdateProductMinValidation()
	{
		$arr = ['price' => -5];
		$product = factory(Product::class)->create();

		$this->assertCantUpdateProduct(
			$product,
			['price'],
			$arr
		);
	}
	
	/**
	 * Тест: обновление товара, проверка exists полей
	 */
	public function  testAdminUpdateProductExistsValidation()
	{
		
		$product = factory(Product::class)->create();
		//$category = factory(Category::class)->create();
		$arr = ['category_id' => 555];
		
		
		$this->assertCantUpdateProduct(
			$product,
			['category_id'],
			$arr
		);
	}
	
	/**
	 * Тест: обновление товара, проверка boolean полей
	 */
	public function  testAdminUpdateProductBooleanValidation()
	{
		$arr = ['is_new' => 'asdas', 'is_recommended' => 'sadas', 'status' => 'asdas'];
		$product = factory(Product::class)->create();
		
		$this->assertCantUpdateProduct(
			$product,
			['is_new', 'is_recommended', 'status'],
			$arr
		);
	}
	
	
	
	
	
	
	// Категория
	
	private function assertCantUpdateCategory($category, $fields, $arr)
	{
		$data = array_merge($category->toArray(), $arr);
		$this->assertCantUpdate(
			'categories',
			'admin/categories/'.$category->id,
			$category->toArray(),
			$fields,
			$data
		);
	}
	
	/*
	 * Тест: создание категории из админки (проверяет что  категория существует в БД)
	 */
	public function testAdminCanCreateCategory()
	{
		$data = ['title' => 'Категория'];
		
		$response = $this->post('/admin/categories', $data); // post запрос на /categories пойдет на роут categories.store
		$response->assertStatus(302);
		$this->assertDatabaseHas('categories', $data);
	}
	
	/*
	 * Тест: создание категории из админки, с пустым названием (проверяет что  категория не существует в БД)
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
	
	
	// Обновление категории, не работает
	public function testAdminUpdateCategoryRequiredValidation()
	{
		$arr = ['title' => ''];
		$category = factory(Category::class)->create();
		
		$this->assertCantUpdateCategory(
			$category,
			['title'],
			$arr
		);
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
