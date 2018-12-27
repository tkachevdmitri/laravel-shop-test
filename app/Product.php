<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['title', 'price'];
	
	// Добавление товара
	public static function add($fields)
	{
		$product = new static;   // новый экземпляр модели
		// присваиваем значения
		$product->fill($fields);
		
		$product->save();
		
		return $product;
	}
}
