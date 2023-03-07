@extends('layouts.admin')

@section('adds-component')
    <script src="{{ asset('public/js/admin/products.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/css/admin/products.css') }}">
@endsection

@section('title')
    {{ $product->title }}
@endsection

@section('admin.main')
    <section class="container my-5">
        <form method="POST" action="{{ route('core.admin.products.edit', ['product' => $product->id]) }}"
            enctype="multipart/form-data">
            <h2 class="mb-4">Продукт: {{ $product->title }}</h2>
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row gy-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название товара</label>
                        <input required type="text" value="{{ $product->title }}" name="title" class="form-control"
                            id="title">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Цена</label>
                        <input required type="number" value="{{ $product->price }}" name="price" class="form-control"
                            id="price">
                        <div class="form-text">Только сумма, без знака рубля. <i>(32000)</i></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание товара</label>
                        <textarea name="description" class="form-control" id="description">{{ $product->description }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sale" class="form-label">Акция/скидка, в процентах товара</label>
                        <input type="number" value="{{ $product->sale }}" name="sale" class="form-control"
                            id="sale">
                        <div class="form-text">Если акции нет, оставьте поле пустым.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="brand" class="form-label">Бренд товара</label>
                        <select required class="form-select" name="brand" id="brand"
                            aria-label="Default select example">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @if ($product->brand == $brand->id) selected @endif>
                                    {{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Бренд обязательное поле, если нужного бренда нет, добавьте его
                            самостоятельно.</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="count" class="form-label">Количество товара</label>
                        <input required type="number" value="{{ $product->count }}" name="count" class="form-control"
                            id="count">
                        <div class="form-text">Просто число. <i>(5)</i></div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="images" class="form-label">Фотографии товара</label>
                        <input class="form-control" required accept=".jpg, .jpeg, .png" name="images[]" multiple
                            type="file" id="images">
                    </div>

                    <div id="image-preview" class="@if (sizeof($product->images)) imageAdded @endif"
                        data-images="{{ $product->images }}">
                        @if ($product->images)
                            @foreach ($product->images as $img)
                                <div class="image-item" data-id="${i}">
                                    <img src="{{ asset($img->url) }}">
                                    <button type="button" class="btn btn-danger btn-sm remove-image"
                                        aria-label="Close">Удалить</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="parent" class="form-label">Категоия товара</label>
                        <select required class="form-select" name="parent" id="parent">
                            <option value="">-</option>
                            @foreach ($categories as $category)
                                <option @if ($product->category == $category->id) selected data-selected="true" @endif
                                    data-attributes="{{ $category->parentAttributes }}" value="{{ $category->id }}">
                                    {{ $category->title }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Характеристики категории и родительских категорий будут применены к товару.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add-attribute" class="form-label">Характеристики товара</label>
                        <div id="attribute-list" data-attributes-value="{{ $product->attributes }}">

                        </div>
                        <div class="form-text">Если какие-то характеристики не нужно поставтье <b>-</b> <i>(дефис)</i> в
                            поле.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="inclusions" class="form-label">Что в комплекте</label>
                        <div class="input-group">
                            <input type="text" id="inclusions" class="form-control">
                            <button type="button" id="add-inclusion" class="btn btn-warning">Добавить</button>
                        </div>
                        <div class="form-text"><i>Документация и т.д. и т.п.</i></div>
                        <div class="mt-3" id="inclusion-list">
                            @foreach ($product->inclusions as $inclusion)
                                <div class="inclusion-item">
                                    <input type="hidden" name="inclusions[]"
                                        value="{{$inclusion->value}}">
                                    <div class="d-flex justify-content-between">
                                        <span class="inclusion-title">{{$inclusion->value}}</span>
                                        <button type="button" class="btn-close" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- <div class="col-sm-8"></div> --}}
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.products') }}" class="btn btn-secondary">Вернуться назад</a>
                        <div>
                            <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" type="submit"
                                class="btn btn-secondary">Отмена</a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#removeProduct">Удалить товар</button>
                            <button type="submit" class="btn btn-primary">Сохранить товар</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <div class="modal fade" id="removeProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Подтвердите действие</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <P>Вы действительно хотите удалить продукт: <b> <br> {{ $product->title }}</b></P>
                </div>
                <form method="POST" class="w-100"
                    action="{{ route('core.admin.products.remove', ['product' => $product->id]) }}">
                    @csrf
                    <div class="btn-group w-100">
                        <button type="button" class="btn rounded-top-0 btn-secondary"
                            data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn rounded-top-0 btn-danger">Удалить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
