<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
	public function index()
	{
		$categories = Category::all();
		$products_recommended = Product::where('is_recommended', 1)->get();  // рекоммендуемые товары
		return view('pages.index', ['categories' => $categories, 'products_recommended' => $products_recommended]);
	}
	
	// страница категории
	public function category($id)
	{
		$categories = Category::all();
		
		$category = Category::where('id', $id)->firstOrFail();
		$products = $category->products()->paginate(2);
		
		return view('pages.category', ['category' => $category, 'products' => $products, 'categories' => $categories]);
	}
	
	// страница товара
	public function show($id)
	{
		dd($id);
	}
	
	// страница каталога
	public function catalog()
	{
		$categories = Category::all();
		//$products = Product::all();
		$products = Product::paginate(2);
		return view('pages.catalog', ['categories' => $categories, 'products' => $products]);
	}
}
