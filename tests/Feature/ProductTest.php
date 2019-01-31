<?php

namespace Tests\Feature;

use App\Category;
use App\Product;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ValidationCreateTrait;
use Tests\ValidationTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductTest extends TestCase
{
	use RefreshDatabase;
	
	use ValidationTrait;
	
	use ValidationCreateTrait;
	
	
	// ТОВАР (данные и методы)
	// массив с данными товара
	public function productData()
	{
		$data = [
			'title' => 'Товар',
			'price' => '2020',
			'article' => '7963456',
			'brand' => 'Adidas',
			'image' => null,
			'description' => 'Описание товара',
			'status' => 1,
			'is_new' => 1,
			'is_recommended' => 1
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
	
	
	/**
	 * Тестирование метода модели Product, который в итоге выпилили
	 */
	/*
	public function testCategory()
	{
		$category = factory(Category::class)->create();
		$product = factory(Product::class)->create();
		$product->category()->associate($category);
		$product->save();
		
		$this->assertEquals($product->category_id, $category->id);
		$this->assertTrue($product->getCategoryID() == $category->id);
	}
	
	public function testNotCategory()
	{
		$product = factory(Product::class)->create(['category_id' => null]);
		$product2 = Product::with('category')->find($product->id);dd($product2);
		$this->assertTrue($product2->getCategoryID() == null);
	}
	*/
	
	
	// Товар (создание нового)
	// NEW TESTS
	/**
	 * @param $product
	 * @param $arr
	 * @param $fields
	 * Метод для тестирования создания товара
	 */
	private function assertCantCreateProduct($product, $arr, $fields)
	{
		$data = array_merge($product, $arr);
		$this->assertCantCreate(
			'products',
			'admin/products/',
			$data,
			$fields
		);
	}
	
	// старые тесты Создание товара
	/*
	 * Тест: создание товара из админки (проверяет что  товар существует в БД)
	 */
	public function testAdminCanCreateProductTest()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$data = $this->productData();
		
		$response = $this->productRequest($data); // post запрос на /categories пойдет на роут products.store
		$response->assertStatus(302);;
		$this->assertDatabaseHas('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с пустым названием (проверяет что  товар не существует в БД)
	 */
	public function testAdminNotCanCreateProductNotTitle()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$data = $this->productData();
		$data['price'] = 20;
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseHas('products', $data);
	}
	
	/*
	 * Тест: создание товара из админки, с ценой, число с плавающей точкой (проверяет что  товар существует в БД)
	 */
	public function testAdminNotCanCreateProductNumberFloatPrice()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$data = $this->productData();
		$data['is_recommended'] = 'sdasd';
		
		$response = $this->productRequest($data);
		$response->assertStatus(302);
		$this->assertDatabaseMissing('products', $data);
	}
	
	
	
	// Тесты по типам полей --------------------
	/**
	 * Тест: required поля, создание товара
	 */
	public function testAdminCantCreateProductRequiredValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['title' => '', 'price' => '', 'article' => '', 'brand' => '', 'category_id' => ''];
		$product = $this->productData();
		
		$this->assertCantCreateProduct($product, $arr, ['title', 'price', 'article', 'brand', 'category_id']);
	}
	
	/**
	 * Тест: image поля, удачное создание товара с изображением
	 */
	public function testAdminCanCreateProductImageValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$category = factory(Category::class)->create();
		Storage::fake('products');
		$response = $this->call('POST', 'admin/products', [
			'title' => 'Товар',
			'price' => '2020',
			'article' => '7963456',
			'brand' => 'Adidas',
			'description' => 'Описание товара',
			'category_id' => $category->id,
			'image' => UploadedFile::fake()->image('product.jpg')
		]);
		$response->assertStatus(302);
		$response->assertSessionHasNoErrors();
		$product = Product::where('title', 'Товар')->first();
		// Assert the file was stored...
		Storage::disk('products')->assertExists($product->image);
	}
	
	
	/**
	 * Тест: image поля, не удачное создание товара, загрузили другой тип файла
	 */
	public function testAdminCantCreateProductImageValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$category = factory(Category::class)->create();
		Storage::fake('products');
		$response = $this->call('POST', 'admin/products', [
			'title' => 'Товар',
			'price' => '2020',
			'article' => '7963456',
			'brand' => 'Adidas',
			'description' => 'Описание товара',
			'category_id' => $category->id,
			'image' => UploadedFile::fake()->create('document.pdf', 100)
		]);
		
		$response->assertStatus(302);
		$response->assertSessionHasErrors(['image']);
	}
	
	/**
	 * Тест: image поле, тестируем что при удалении товара, его изображение тоже удаляется
	 */
	public function testAdminRemoveProductRemoveImage()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		// создаем категорию и товар
		$category = factory(Category::class)->create();
		Storage::fake('products');
		$response = $this->call('POST', 'admin/products', [
			'title' => 'Товар',
			'price' => '2020',
			'article' => '7963456',
			'brand' => 'Adidas',
			'description' => 'Описание товара',
			'category_id' => $category->id,
			'image' => UploadedFile::fake()->image('product.jpg')
		]);
		$response->assertStatus(302);
		$response->assertSessionHasNoErrors();
		$product = Product::where('title', 'Товар')->first();
		
		// Assert the file was stored...
		Storage::disk('products')->assertExists($product->image);
		
		// если товар существует в БД то удаляем его
		if($this->assertDatabaseHas('products', ['id' => $product->id])){
			$response = $this->call('DELETE', 'admin/products/'.$product->id);
			//$response->assertStatus(302);
			$this->assertDatabaseMissing('products', ['id' => $product->id]);
			Storage::disk('products')->assertMissing($product->image); // проверяем что изображения больше нет
		}
	}
	
	
	/**
	 * Тест: unique поля, создание товара БЕЗ TRAIT
	 */
	public function  testAdminCantCreateProductUniqueValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		// создаем два товара, с одинаковыми данными, проверяем что в базе товар 1
		$data = $this->productData();
		$product = factory(Product::class)->create($data);
		$response = $this->productRequest($data);
		
		
		$this->assertCount(1, Product::all());
	}
	
	/**
	 * Тест: numeric поля, создание товара
	 */
	public function testAdminCantCreateProductNumericValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['price' => 'asdsa'];
		$product = $this->productData();
		
		$this->assertCantCreateProduct($product, $arr, ['price']);
	}
	
	/**
	 * Тест: min поля, создание товара
	 */
	public function testAdminCantCreateProductMinValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['price' => -50];
		$product = $this->productData();
		
		$this->assertCantCreateProduct($product, $arr, ['price']);
	}
	
	/**
	 * Тест: exists поля, создание товара
	 */
	public function testAdminCantCreateProductExistsValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['category_id' => 122];
		$product = $this->productData();
		
		$this->assertCantCreateProduct($product, $arr, ['category_id']);
	}
	
	/**
	 * Тест: boolean поля, создание товара
	 */
	public function testAdminCantCreateProductBooleanValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['is_new' => '', 'is_recommended' => '', 'status' => ''];
		$product = $this->productData();
		
		$this->assertCantCreateProduct($product, $arr, ['is_new', 'is_recommended', 'status']);
	}
	
	
	// Товар (удаление)
	public function testAdminRemoveProduct()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$product = factory(Product::class)->create();
		if($this->assertDatabaseHas('products', ['id' => $product->id])){
			$response = $this->call('DELETE', 'admin/products/'.$product->id);
			//$response->assertStatus(302);
			$this->assertDatabaseMissing('products', ['id' => $product->id]);
		}
	}
	
	
	
	// Товар (обновление)
	/**
	 * @param $product
	 * @param $fields
	 * @param $arr
	 * Метод для обновления товара
	 */
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['price' => 'sas'];
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['is_new' => '', 'is_recommended' => '', 'status' => ''];
		$product = factory(Product::class)->create();
		
		$this->assertCantUpdateProduct(
			$product,
			['is_new', 'is_recommended', 'status'],
			$arr
		);
	}
	
	
}
