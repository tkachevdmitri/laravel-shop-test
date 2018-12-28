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
                        <th>Бренд</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->article}}</td>
                        <td>{{$product->title}}</td>
                        <td>{{$product->price}}</td>
                        <td>-</td>
                        <td>{{$product->brand}}</td>
                        <td>
                            <a href="{{route('products.edit', $product->id)}}" title="Редактировать">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                        </td>
                        <td>
                            {!! Form::open ([
                                'route' => ['products.destroy', $product->id],
                                'method' => 'delete'
                            ])!!}
                                <button type="submit" onclick="return confirm('Вы действительно хотите удалить товар {{$product->title}}?')" class="delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </section>
@endsection