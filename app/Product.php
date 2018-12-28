<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['title', 'price', 'category_id', 'article', 'brand', 'description', 'is_new', 'is_recommended', 'status'];
	
	
	// Связи таблиц
	// Товар привязан к определенной категории (одной категории)
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
	
	
	// Методы для работы с товаром
	// Добавление товара - не используется
	public static function add($fields)
	{
		$product = new static;   // новый экземпляр модели
		// присваиваем значения
		$product->fill($fields);
		
		$product->save();
		
		return $product;
	}
	
	
	// Редактирование, обновление товара - не используется
	public function edit($fields)
	{
		$this->fill($fields);
		$this->save();
	}
	
	
	// Вывод id категории, для выпадающего селекта
	public function getCategoryID()
	{
		return $this->category != null ? $this->category->id : null;
	}
	
}
