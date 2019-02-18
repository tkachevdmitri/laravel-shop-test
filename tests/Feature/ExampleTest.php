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
	
	
	// FRONT TESTS
	// тестируем ответ главной страницы
	public function testHomePageStatus()
	{
		$response = $this->get('/');
		$response->assertStatus(200);
		$response->assertViewIs('pages.index');
	}
	// тестируем ответ страницы каталога
	public function testCatalogPageStatus()
	{
		$response = $this->get('/catalog/');
		$response->assertStatus(200);
		$response->assertViewIs('pages.catalog');
	}
	/**/
	// тестируем ответ страницы категория (конкретная категория)
	public function testCategoryPageStatus()
	{
		$category = factory(Category::class)->create();
		$response = $this->get('/category/'.$category->id);
		$response->assertStatus(200);
		$response->assertViewIs('pages.category');
	}
	
	
	public function testCatalogPagination()
	{
		$product1 = factory(Product::class)->create(['title' => 'Товар 1', 'article' => 1]);
		$product2 = factory(Product::class)->create(['title' => 'Товар 2', 'article' => 2]);
		$product3 = factory(Product::class)->create(['title' => 'Товар 3', 'article' => 3]);
		$product4 = factory(Product::class)->create(['title' => 'Товар 4', 'article' => 4]);
		$product5 = factory(Product::class)->create(['title' => 'Товар 5', 'article' => 5]);
		
		$response = $this->get('/catalog');
		$response->assertViewIs('pages.catalog');
		$response->assertSeeTextInOrder(['Товар 1', 'Товар 2']);
		
		$response = $this->get('/catalog?page=2');
		$response->assertViewIs('pages.catalog');
		$response->assertSeeTextInOrder(['Товар 3', 'Товар 4']);
		
		$response = $this->get('/catalog?page=3');
		$response->assertViewIs('pages.catalog');
		$response->assertSeeTextInOrder(['Товар 5']);
		
		/*
		for($i = 1; $i <= 3; $i++){
			$response = $this->get('/catalog?page='.$i);
			$response->assertViewIs('pages.catalog');
			$response->assertSeeTextInOrder(['Товар '.$i, 'Товар '.$i]);
		}
		*/
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
	
	
	// ADMIN TESTS
	// статусы страниц
	/*
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
	*/
	
}
