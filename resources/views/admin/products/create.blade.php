@extends('admin.layout')

@section('content')
    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/admin/">Админпанель</a></li>
                        <li><a href="/admin/products/">Управление товарами</a></li>
                        <li class="active">Редактировать товар</li>
                    </ol>
                </div>


                <h4>Добавить новый товар</h4>

                <br/>


                <div class="col-lg-4">
                    <!-- ошибки валидации -->
                    @include('admin.errors')

                    <div class="login-form">
                        {{Form::open([
                            'route' => 'products.store',
                            'files' => true
                        ])}}

                            <p>Название товара</p>
                            <input type="text" name="title" placeholder="" value="{{old('title')}}">


                            <p>Стоимость, $</p>
                            <input type="text" name="price" placeholder="" value="{{old('price')}}">

                            <p>Категория</p>
                            <select name="category_id">
                                <option value="1">Категория 1</option>
                                <option value="2">Категория 2</option>
                            </select>

                            <p>Артикул</p>
                            <input type="text" name="article" placeholder="" value="{{old('article')}}">

                            <p>Бренд</p>
                            <input type="text" name="brand" placeholder="" value="{{old('brand')}}">

                            <p>Изображение товара</p>
                            <input type="file" name="image" placeholder="" value="">

                            <p>Опписание</p>
                            <textarea name="description"></textarea>

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

                        {{Form::close()}}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection