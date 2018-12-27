@extends('admin.layout')


@section('content')
    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/admin">Админпанель</a></li>
                        <li>Управление товарами</li>
                    </ol>
                </div>

                <a href="{{route('products.create')}}" class="btn btn-default back">
                    <i class="fa fa-plus"></i> Добавить товар
                </a>

                <h4>Список товаров</h4>

                <br/>

                <table class="table-bordered table-striped table">
                    <tr>
                        <th>ID товара</th>
                        <th>Артикул</th>
                        <th>Название товара</th>
                        <th>Цена</th>
                        <th>Категория</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>-</td>
                        <td>{{$product->title}}</td>
                        <td>{{$product->price}}</td>
                        <td>-</td>
                        <td><a href="#" title="Редактировать"><i class="fa fa-pencil-square-o"></i></a></td>
                        <td><a href="#" title="Удалить"><i class="fa fa-times"></i></a></td>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </section>
@endsection