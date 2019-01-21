<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$products = Product::all();
		return view('admin.products.index', ['products' => $products]);
    }

    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$categories = Category::pluck('title', 'id')->all();
    	return view('admin.products.create', ['categories' => $categories]);
    }

    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
		
		//$product = Product::add($request->all());
		$product = new Product;
		$product->fill($request->all());
		if(!$request->get('status')){
			$product->status = 0;
		}
		
		// Обработка изображений
		if($request->image !== null){
			$path = Storage::disk('products')->putFile(
				'/', $request->file('image')
			);
			$product->image = $path;
		}
		$product->save();
		
		return redirect()->route('products.index');
    }
    

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
		$categories = Category::pluck('title', 'id')->all();
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
	
		$product = Product::find($id);
		$product->fill($request->all());
		
		if(!$request->get('is_new')){
			$product->is_new = 0;
		}
		if(!$request->get('is_recommended')){
			$product->is_recommended = 0;
		}
		if(!$request->get('status')) {
			$product->status = 0;
		}
	
		// Обработка изображений
		$product->removeImage();
		if($request->image !== null){
			$path = Storage::disk('products')->putFile(
				'/', $request->file('image')
			);
			$product->image = $path;
		}
		
		$product->save();
		
		
		return redirect()->route('products.index');
    }

    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		//Product::find($id)->delete();
		
    	$product = Product::find($id);
		$product->removeImage();
		$product->delete();
		
		return redirect()->route('products.index');
    }
    
    
}
