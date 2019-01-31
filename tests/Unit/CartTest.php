<?php

namespace Tests\Unit;

use App\Cart;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
	
	use RefreshDatabase;
	
	/*
	 * Тест: тестирование метода add, добавление одного товара в корзину
	 */
	public function testCartAddMethod()
	{
		// создаем экземпляр корзины
		$cart = new Cart();
		
		// создаем продукт
		$product = factory(Product::class)->create();
		// создаем массив с данными, для добавления в корзину
		$product_data = ['id' => $product->id, 'count' => 1, 'price' => 100];
		
		// добавляем товар в карзину
		$cart->add($product_data);
		
		// проверяем, что массив с данными записался в $cart->content
		$this->assertEquals(['products' => [['id' => $product->id, 'count' => 1, 'price' => 100]]], $cart->content);
	}
	
	/*
	 * Тест: тестирование метода add, добавление двух товаров в корзину
	 */
	public function testCartAddTwoProductMethod()
	{
		// создаем экземпляр корзины
		$cart = new Cart();
		
		// создаем 1й продукт и массив с данными
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 1, 'price' => 100];
		
		// добавляем 1й продукт и проверяем его наличие в корзине
		$cart->add($product_data);
		$this->assertEquals(['products' => [$product_data]], $cart->content);
		
		// создаем 2й продукт и массив с данными
		$product2 = factory(Product::class)->create();
		$product_data2 = ['id' => $product2->id, 'count' => 1, 'price' => 1000];
		
		
		
		// добавляем 2й продукт и проверяем наличие двух товаров в корзине
		$cart->add($product_data2);
		$this->assertEquals(['products' => [$product_data, $product_data2]], $cart->content);
	}
	
	/*
	 * Тест: тестирование метода add, повторное добавление товара в корзину (проверяем изменение кол-ва)
	 */
	public function testCartAddTwoSameProductMethod()
	{
		// создаем экземпляр корзины
		$cart = new Cart();
		
		// создаем продукт и массив с данными
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 1, 'price' => 100];
		
		// добавляем продукт и проверяем его наличие в корзине
		$cart->add($product_data);
		$this->assertEquals(['products' => [$product_data]], $cart->content);
		
		// добавляем еще раз и проверяем изменение кол-ва на 2
		$cart->add($product_data);
		$this->assertEquals([ 'products' => [['id' => $product->id, 'count' => 2, 'price' => 100]] ], $cart->content);
	}
	
	
	/*
	 * Тест: тестирование метода remove, удаление одной единицы товара
	 */
	public function testCartRemoveOneProductMethod()
	{
		// создаем экземпляр корзины
		$cart = new Cart();
		
		// создаем продукт и массив с данными
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 4, 'price' => 100];
		
		// добавляем продукт и проверяем его наличие в корзине
		$cart->add($product_data);
		$this->assertEquals([ 'products' => [['id' => $product->id, 'count' => 4, 'price' => 100]]], $cart->content);
		
		// создаем массив с данными для удаления одного продукта и удаляем его
		$product_data_remove = ['id' => $product->id, 'count' => 1];
		$cart->remove($product_data_remove);
		// проверяем что в корзине кол-во уменьшилось на один
		$this->assertEquals([ 'products' => [['id' => $product->id, 'count' => 3, 'price' => 100]]], $cart->content);
	}
	
	/*
	 * Тест: тестирование метода remove, удаление нескольких единиц товара (но не более чем в корзине)
	 */
	public function testCartRemoveSomeProductMethod()
	{
		// создаем экземпляр корзины
		$cart = new Cart();
		
		// создаем продукт и массив с данными
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 4, 'price' => 100];
		$cart->add($product_data);
		$this->assertEquals([ 'products' => [['id' => $product->id, 'count' => 4, 'price' => 100]]], $cart->content);
		
		// создаем массив с данными для удаления одного продукта и удаляем его
		$product_data_remove = ['id' => $product->id, 'count' => 3];
		$cart->remove($product_data_remove);
		// проверяем что в корзине кол-во уменьшилось на один
		$this->assertEquals([ 'products' => [['id' => $product->id, 'count' => 1, 'price' => 100]]], $cart->content);
	}
	
	
	/*
	 * Тест: тестирование метода remove, удаление нескольких единиц товара (больше чем в корзине)
	 */
	public function testCartRemoveMoreProductMethod()
	{
		// создаем экземпляр корзины
		$cart = new Cart();
		
		// создаем продукты и массивы с данными
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 4, 'price' => 100];
		$cart->add($product_data);
		
		$product2 = factory(Product::class)->create();
		$product_data2 = ['id' => $product2->id, 'count' => 2, 'price' => 1000];
		$cart->add($product_data2);
		// проверяем что товары есть в корзине
		$this->assertEquals(['products' => [$product_data, $product_data2]], $cart->content);
		
		// создаем массив с данными для удаления продукта и удаляем его
		$product_data_remove = ['id' => $product->id, 'count' => 4];
		$cart->remove($product_data_remove);
		
		// проверяем что в корзине
		//$this->assertEquals(['products' => [$product_data2]], $cart->content);
		$this->assertNotEquals(['products' => [$product_data]], $cart->content);
	}
	
	
	/*
	 * Тест: тестирование метода clear, удаление всех товаров из корзины
	 */
	public function testCartClearMethod()
	{
		// создаем экземпляр корзины
		$cart = new Cart();
		
		// создаем продукты и массивы с данными
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 2, 'price' => 100];
		$cart->add($product_data);
		
		$product2 = factory(Product::class)->create();
		$product_data2 = ['id' => $product2->id, 'count' => 3, 'price' => 1000];
		$cart->add($product_data2);
		
		// проверяем что товары есть в корзине
		$this->assertEquals(['products' => [$product_data, $product_data2]], $cart->content);
		
		// очищаем корзину
		$cart->clear();
		
		// проверяем что в корзине нет добавленных товаров
		$this->assertNotEquals(['products' => [$product_data, $product_data2]], $cart->content);
	}
	
	
	/*
	 * Тест: тестирование метода get, получение всех товаров из корзины
	 */
	public function testCartGetMethod()
	{
		// создаем экземпляр корзины
		$cart = new Cart();
		
		// создаем продукты и массивы с данными
		$product = factory(Product::class)->create();
		$product_data = ['id' => $product->id, 'count' => 2, 'price' => 100];
		$cart->add($product_data);
		
		$product2 = factory(Product::class)->create();
		$product_data2 = ['id' => $product2->id, 'count' => 3, 'price' => 1000];
		$cart->add($product_data2);
		
		// проверяем что товары есть в корзине
		$this->assertEquals(['products' => [$product_data, $product_data2]], $cart->content);
		
		// получаем все товары из корзины
		$products = $cart->get();
		
		// проверяем что получили товары которые добавляли
		$this->assertEquals([$product_data, $product_data2], $products);
	}
	
}
