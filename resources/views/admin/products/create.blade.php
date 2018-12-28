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
                            <!--
                                category_id - название инпута
                                2й параметр - массив из значений, где 'L' - value, 'Large' - подпись
                                null - выбранное значение по умолчаниюкакие эл-ты уже выбраны
                                4й параметр - массив с атрибутами html данных
                            -->
                            {{Form::select('category_id',
                                $categories,
                                null
                                )
                            }}
                            <br><br>

                            <p>Артикул</p>
                            <input type="text" name="article" placeholder="" value="{{old('article')}}">

                            <p>Бренд</p>
                            <input type="text" name="brand" placeholder="" value="{{old('brand')}}">

                            <p>Изображение товара</p>
                            <input type="file" name="image" placeholder="" value="">

                            <p>Опписание</p>
                            <textarea name="description">{{old('description')}}</textarea>

                            <div class="input_wrap">
                                <label>
                                    <input type="checkbox" name="is_new" value="1">
                                    Новинка
                                </label>
                            </div>

                            <div class="input_wrap">
                                <label>
                                    <input type="checkbox" name="is_recommended" value="1">
                                    Рекоммендуемый
                                </label>
                            </div>

                            <div class="input_wrap">
                                <label>
                                    <input type="checkbox" checked name="status" value="1">
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