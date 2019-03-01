<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Cart;

class CartController extends Controller
{
	/*
	private $cart;
	
	public function __construct(Cart $cart)
	{
		$this->cart = $cart;
	}*/
	
	public function add(Request $request){
		$cart = new Cart();
    	//$cart = app()->make('Cart');
    	$cart->add($request->get('product'));
		return redirect()->back();
	}
	
	public function remove(Request $request)
	{
		//$cart = new Cart();
		$cart = app()->make('Cart');
		$cart->remove($request->get('product'));
		return redirect()->back();
	}
	
	public function clear()
	{
		//$cart = new Cart();
		$cart = app()->make('Cart');
		$cart->clear();
		return redirect()->back();
	}
	
	public function get()
	{
		$categories = Category::all();
		
		//$cart = new Cart();
		$cart = app()->make('Cart');
		$products = $cart->get();
		return view('pages.cart', ['categories' => $categories, 'products' => $products, 'cart' => $cart]);
	}
}
