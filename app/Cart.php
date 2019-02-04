<?php

namespace App;


class Cart
{
	private static $instance = null;
	public $content;
	
	/*
	 * @return Cart
	*/
	public static function getInstance()
	{
		if (null === self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	//private function __clone() {}
	private function __construct()
	{
		session()->has('cart') ? $this->content = session()->get('cart') : $this->content = ['products' => []];
	}
	
	
	public function __destruct()
	{
		session(['cart' => $this->content]);
	}
	
	/*
	 * метод для добавления товара в корзину
	 */
	public function add($data)
	{
		if(count($this->content['products'])){
			/*
			foreach ($this->content['products'] as $key => $product){
				if($product['id'] == $data['id']){
					echo 'увеличили кол-во существующего товара';
					$this->content['products'][$key]['count'] += $data['count'];
					break;
				} else {
					echo 'добавили новый товар в корзину с товарами';
					$this->content['products'][] = $data;
					break;
				}
			}
			*/
			
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
	
}
