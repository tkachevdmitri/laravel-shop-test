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
                    <div class="login-form">
                        <form action="#" method="post" enctype="multipart/form-data">

                            <p>Название товара</p>
                            <input type="text" name="name" placeholder="" value="">


                            <p>Стоимость, $</p>
                            <input type="text" name="price" placeholder="" value="">


                            <input type="submit" name="submit" class="btn btn-default" value="Сохранить">

                            <br/><br/>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection