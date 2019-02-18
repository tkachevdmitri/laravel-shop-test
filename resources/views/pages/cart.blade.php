@extends('layout')


@section('content')

    <div class="features_items">
        <h2 class="title text-center">Корзина</h2>

        @if(count($products))
            <p>Вы выбрали такие товары:</p>
            <table class="table-bordered table-striped table">
                <tbody><tr>
                    <th>ID товара</th>
                    <th>Название</th>
                    <th>Стомость, руб</th>
                    <th>Количество, шт</th>
                    <th>Удалить</th>
                </tr>
                @foreach($products as $product)
                    <tr>

                        <td>{{$product['id']}}</td>
                        <td>
                            <a href="{{route('product.show', $product['id'])}}">{{ $cart->getProductInfo($product['id'])->title }}</a>
                        </td>
                        <td>{{ $cart->getProductInfo($product['id'])->price }}</td>
                        <td>{{$product['count']}}</td>
                        <td>
                            {!! Form::open(['route' => 'cart.remove']) !!}
                                <div class="hidden">
                                    <input type="text" name="product[id]" value="{{$product['id']}}">
                                    <input type="text" name="product[count]" value="{{$product['count']}}">
                                </div>
                                <button type="submit" class="delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">Общая стоимость, руб:</td>
                    <td>{{ $cart->getTotalCost() }}</td>
                </tr>

                </tbody></table>

                <a class="btn btn-default checkout" href="/cart/checkout"><i class="fa fa-shopping-cart"></i> Оформить заказ</a>
                <a onclick="return confirm('Вы действительно хотите очистить корзину?' );" class="btn btn-default checkout" href="/cart/clear"><i class="fa fa-times"></i> Очистить корзину</a>
        @else
            <p>Ваша корзина пуста</p>
        @endif

    </div>

@endsection