<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;

class CartController extends Controller
{
    public function add(Request $request){
    	//dd($request->get('product'));
    	$cart = Cart::getInstance();
    	$cart->add($request->get('product'));
		//return redirect()->back();
	}
	
	public function remove(Request $request)
	{
		$cart = Cart::getInstance();
		$cart->remove($request->get('product'));
	}
	
	public function clear()
	{
		$cart = Cart::getInstance();
		return $cart->clear();
	}
	
	public function get()
	{
		$cart = Cart::getInstance();
		return $cart->get();
	}
}
