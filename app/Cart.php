<?php

namespace App;


use Illuminate\Support\Facades\Session;

class Cart
{

	public $content;
	
	
	public function __construct()
	{
		session()->has('cart') ? $this->content = session()->get('cart') : $this->content = ['products' => []];
		
	}
	
	
	public function __destruct()
	{
		//dd(app());
		session(['cart' => $this->content]);
		//dd(session()->all());
		//Session::put('cart', $this->content);
	}
	
	/*
	 * метод для добавления товара в корзину
	 */
	public function add($data)
	{
		//dd($data);
		if(count($this->content['products'])){
			$inCart = false;
			foreach ($this->content['products'] as $key => $product){
				if($product['id'] == $data['id']){
					//echo 'увеличили кол-во существующего товара';
					$this->content['products'][$key]['count'] += $data['count'];
					$inCart = true;
					break;
				}
			}
			if(!$inCart){
				//echo 'добавили новый товар в корзину с товарами';
				$this->content['products'][] = $data;
			}
			
		} else {
			//echo 'товар добавили в пустую корзину';
			$this->content['products'][] = $data;
		}
	}
	
	/*
	 * метод для удаления товара из корзины
	 */
	public function remove($data)
	{
		foreach ($this->content['products'] as $key => $product){
			if($product['id'] == $data['id']){
				if($this->content['products'][$key]['count'] - $data['count'] > 0){
					$this->content['products'][$key]['count'] -= $data['count'];
				} else {
					unset($this->content['products'][$key]);
					sort($this->content['products']);
				}
			}
		}
	}
	
	/*
	 * метод для очистки корзины
	 */
	public function clear()
	{
		$this->content = ['products' => []];
	}
	
	/*
	 * метод для получения всех товаров из корзины
	 */
	public function get()
	{
		return $this->content['products'];
	}
	
	/*
	 * метод для получения информации о конкретном товаре
	 */
	public function getProductInfo($id)
	{
		return Product::where('id', $id)->firstOrfail();
	}
	
	/*
	 * метод для получения общей суммы
	 */
	public function getTotalCost()
	{
		if(count($this->content['products'])){
			$summ = 0;
			foreach($this->content['products'] as $key => $product ){
				$summ += $product['price'] * $product['count'];
			}
			return $summ;
		}
	}
	
	
	// не совмем понял по этим двум методам, как мне правильно выводить кол-во товаров в шапке сайта
	public function getTotalCount()
	{
		if(count($this->content['products'])){
			$count = 0;
			
			foreach($this->content['products'] as $key => $product ){
				$count += $product['count'];
			}
			return $count;
		} else {
			return 0;
		}
	}
	
	/*
	 * метод для получения количества товаров в корзине (вызывается в layout)
	 */
	public static function getCount()
	{
		$cart = new static;
		if(count($cart->content['products'])){
			$count = 0;
			
			foreach($cart->content['products'] as $key => $product ){
				$count += $product['count'];
			}
			return $count;
		} else {
			return 0;
		}
	}
	
	
}
