<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['title', 'price', 'article', 'brand', 'description', 'category_id'];
	
	// статусы товара
	const IS_DRAFT = 0;
	const IS_PUBLIC = 1;
	// новый товар или нет
	const IS_NEW = 1;
	const IS_DEFAULT_NEW = 0;
	// рекоммендуемый товар или нет
	const IS_RECOMMENDED = 1;
	const IS_DEFAULT_RECOMMENDED = 0;
	
	
	// Связи таблиц
	// Товар привязан к определенной категории (одной категории)
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
	
	
	
	// Методы для работы с товаром
	// Добавление товара
	public static function add($fields)
	{
		$product = new static;   // новый экземпляр модели
		// присваиваем значения
		$product->fill($fields);
		
		$product->save();
		
		return $product;
	}
	
	// Редактирование, обновление товара
	public function edit($fields)
	{
		$this->fill($fields);
		$this->save();
	}
	
	// Установки статуса товара (отображается или нет)
	public function setDraft()
	{
		$this->status = Product::IS_DRAFT;
		$this->save();
	}
	public function setPublic()
	{
		$this->status = Product::IS_PUBLIC;
		$this->save();
	}
	public function toggleStatus($value)
	{
		if($value == null) {
			return $this->setDraft();
		}
		return $this->setPublic();
	}
	
	
	// Установка "Новинка"
	public function setNew()
	{
		$this->is_new = Product::IS_NEW;
		$this->save();
	}
	public function setDefaultNew()
	{
		$this->is_new = Product::IS_DEFAULT_NEW;
	}
	public function toggleNew($value)
	{
		if($value == null){
			return $this->setDefaultNew();
		}
		return $this->setNew();
	}
	
	// Установка "Рекоммендуемый"
	public function setRecommended()
	{
		$this->is_recommended = Product::IS_RECOMMENDED;
		$this->save();
	}
	public function setDefaultRecommended()
	{
		$this->is_recommended = Product::IS_DEFAULT_RECOMMENDED;
		$this->save();
	}
	public function toggleRecommended($value)
	{
		if($value == null){
			return $this->setDefaultRecommended();
		}
		return $this->setRecommended();
	}
}
