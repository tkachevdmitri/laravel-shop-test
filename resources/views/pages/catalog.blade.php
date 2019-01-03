@extends('layout')


@section('content')

    <div class="features_items"><!--features_items-->
        <!--<h2 class="title text-center">Последние товары</h2>-->

        <div class="row">
			@foreach($products as $product)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{$product->image}}" alt="{{$product->title}}" />
                                <h2>{{$product->price}} руб</h2>
                                <p>
                                    <a href="{{route('product.show', $product->id)}}">
                                        {{$product->title}}
                                    </a>
                                </p>
                                <a href="#" data-id="" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                            </div>
                            @if($product->is_new)
                                <img src="/images/home/new.png" class="new" alt="new">
                            @endif
                        </div>
                    </div>
                </div>
			@endforeach
        </div>

        <!-- Постраничная навигация -->
        <div class="pagination_block" style="text-align: center;">
            {{$products->links()}}
        </div>



    </div><!--features_items-->

@endsection