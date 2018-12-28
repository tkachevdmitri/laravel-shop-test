@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="row">

            <br/>

            <h4>Добрый день, администратор!</h4>

            <br/>

            <p>Вам доступны такие возможности:</p>

            <br/>

            <ul>
                <li><a href="{{route('products.index')}}">Управление товарами</a></li>
                <li><a href="{{route('categories.index')}}">Управление категориями</a></li>
                <li><a href="#">Управление заказами</a></li>
            </ul>

        </div>
    </div>

@endsection