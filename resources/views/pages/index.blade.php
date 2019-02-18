@extends('layout')



@section('content')

    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Рекоммендуемые товары</h2>

		@foreach($products_recommended as $product)
            <div class="col-sm-4">
                {{Form::open([
                    'route' => 'cart.add',
                    'class' => 'tovar_form'
                ])}}
                <div class="hidden">
                    <input type="text" name="product[id]" value="{{$product->id}}">
                    <input type="text" name="product[count]" value="1">
                    <input type="text" name="product[price]" value="{{$product->price}}">
                </div>
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{$product->getImage()}}" alt="{{$product->title}}" />
                            <h2>{{$product->price}} руб</h2>
                            <p>
                                <a href="{{route('product.show', $product->id)}}">
                                    {{$product->title}}
                                </a>
                            </p>
                            <button type="submit" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</button>
                        </div>
                        @if($product->is_new)
                            <img src="/images/home/new.png" class="new" alt="new">
                        @endif
                    </div>
                </div>
                {{Form::close()}}
            </div>
        @endforeach

    </div><!--features_items-->

@endsection