@extends('admin.layout')


@section('content')

    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/admin">Админпанель</a></li>
                        <li><a href="/admin/product">Управление товарами</a></li>
                        <li class="active">Редактировать товар</li>
                    </ol>
                </div>


                <h4>Редактировать товар <strong>{{$product->title}}</strong></h4>

                <br/>

                <div class="col-lg-4">

                    <!-- ошибки валидации -->
                    @include('admin.errors')

                    <div class="login-form">

                        {!! Form::open([
                            'route' => ['products.update', $product->id],
                            'files' => true,
                            'method' => 'put'
                        ]) !!}


                            <p>Название товара</p>
                            <input type="text" name="title" placeholder="" value="{{$product->title}}">


                            <p>Стоимость, $</p>
                            <input type="text" name="price" placeholder="" value="{{$product->price}}">

                            <p>Категория</p>
                            <select name="category_id">
                                <option value="">Категория 1</option>
                                <option value="">Категория 2</option>
                            </select>

                            <p>Артикул</p>
                            <input type="text" name="article" placeholder="" value="{{$product->article}}">

                            <p>Бренд</p>
                            <input type="text" name="brand" placeholder="" value="{{$product->brand}}">

                            <p>Изображение товара</p>
                            <input type="file" name="image" placeholder="" value="">

                            <p>Опписание</p>
                            <textarea name="description">{{$product->description}}</textarea>

                            <div class="input_wrap">
                                <label>
                                    <input type="checkbox" name="is_new">
                                    Новинка
                                </label>
                            </div>

                            <div class="input_wrap">
                                <label>
                                    <input type="checkbox" name="is_recommended">
                                    Рекоммендуемый
                                </label>
                            </div>

                            <div class="input_wrap">
                                <label>
                                    <input type="checkbox" checked name="status">
                                    Статус товара
                                </label>
                            </div>

                            <br>

                            <input type="submit" name="submit" class="btn btn-default" value="Сохранить">

                            <br/><br/>


                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection