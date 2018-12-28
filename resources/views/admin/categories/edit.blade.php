@extends('admin.layout')


@section('content')

    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/admin">Админпанель</a></li>
                        <li><a href="/admin/category">Управление категориями</a></li>
                        <li class="active">Редактировать категорию</li>
                    </ol>
                </div>


                <h4>Редактировать категорию <strong>"{{$category->title}}"</strong></h4>

                <br/>

                <div class="col-lg-4">

                    @include('admin.errors')

                    <div class="login-form">
                        {!! Form::open([
                            'route' => ['categories.update', $category->id],
                            'method' => 'put'
                        ]) !!}

                            <p>Название</p>
                            <input type="text" name="title" placeholder="" value="{{$category->title}}">

                            <br><br>

                            <input type="submit" name="submit" class="btn btn-default" value="Сохранить">

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection