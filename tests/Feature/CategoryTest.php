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
	
	use ValidationTrait;
	
	use ValidationCreateTrait;
	
	
	
	// Категория (создание)  ------------------------------------------
	/**
	 * @param $category
	 * @param $arr
	 * @param $fields
	 * Метод для тестирования создания товара
	 */
	private function assertCantCreateCategory($category, $arr, $fields)
	{
		$data = array_merge($category, $arr);
		$this->assertCantCreate(
			'categories',
			'admin/categories/',
			$data,
			$fields
		);
	}
	
	/**
	 * Тест: required поля, создание категории
	 */
	public function testAdminCantCreateCategoryRequiredValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['title' => ''];
		$category = ['title' => 'Категория'];
		
		$this->assertCantCreateCategory($category, $arr, ['title']);
	}
	
	/**
	 * Тест: unique поля, создание категории БЕЗ TRAIT
	 */
	public function testAdminCantCreateCategoryUniqueValidate()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['title' => 'Категория 1'];
		$category = factory(Category::class)->create($arr);
		$response = $this->post('/admin/categories', $arr);
		
		$this->assertCount(1, Category::all());
	}
	
	
	// старые тесты
	/*
	 * Тест: создание категории из админки (проверяет что  категория существует в БД)
	 */
	public function testAdminCanCreateCategory()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
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
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$data = ['title' => 'Категория'];
		
		$response = $this->post('/admin/categories', $data);
		$response = $this->post('/admin/categories', $data);
		$response->assertStatus(302);
		$this->assertCount(1, Category::all());
	}
	
	// Категория (удаление)
	public function testAdminRemoveCategory()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$category = factory(Category::class)->create();
		if($this->assertDatabaseHas('categories', ['id' => $category->id])){
			$response = $this->call('DELETE', 'admin/categories/'.$category->id);
			//$response->assertStatus(302);
			$this->assertDatabaseMissing('categories', ['id' => $category->id]);
		}
	}
	
	
	// Категория (обновление)
	/**
	 * @param $category
	 * @param $fields
	 * @param $arr
	 * Метод для обновления категории
	 */
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
	
	/**
	 * Тест required поля, обновление категории
	 */
	public function testAdminUpdateCategoryRequiredValidation()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['title' => ''];
		$category = factory(Category::class)->create();
		
		$this->assertCantUpdateCategory(
			$category,
			['title'],
			$arr
		);
	}
	
	/**
	 * Тест unique поля, обновление категории
	 */
	public function  testAdminUpdateCategoryUniqueValidation()
	{
		// создаем и авторизуем пользователя
		$user = factory(User::class)->create();
		$this->be($user);
		
		$arr = ['title' => 'Category 1'];
		$category1 = factory(Category::class)->create($arr);
		$category2 = factory(Category::class)->create();
		
		$this->assertCantUpdateCategory(
			$category2,
			['title'],
			$arr
		);
	}
	
}
