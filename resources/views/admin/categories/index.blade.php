@extends('admin.layout')


@section('content')

    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/admin">Админпанель</a></li>
                        <li class="active">Управление категориями</li>
                    </ol>
                </div>

                <a href="{{route('categories.create')}}" class="btn btn-default back"><i class="fa fa-plus"></i> Добавить категорию</a>

                <h4>Список категорий</h4>

                <br/>

                <table class="table-bordered table-striped table">
                    <tr>
                        <th>ID категории</th>
                        <th>Название категории</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->title}}</td>
                        <td>
                            <a href="{{route('categories.edit', $category->id)}}" title="Редактировать">
                                <i class="fa fa-pencil-square-o"></i>
                            </a>
                        </td>
                        <td>
                            {!! Form::open([
                                'route' => ['categories.destroy', $category->id],
                                'method' => 'delete'
                            ]) !!}
                            <button type="submit" onclick="return confirm('Вы действительно хотите удалить категорию {{$category->title}}?')">
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