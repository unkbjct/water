@extends('layouts.admin')

@section('adds-component')
    <script src="{{ asset('public/js/admin/products.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/css/admin/products.css') }}">
@endsection

@section('admin.main')
    <section class="container my-5">
        <form method="POST" action="{{ route('core.admin.products.create') }}" enctype="multipart/form-data">
            <h2 class="mb-4">Создание нового товара</h2>
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
                        <input required type="text" value="{{ old('title') }}" name="title" class="form-control"
                            id="title">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Цена</label>
                        <input required type="number" value="{{ old('price') }}" name="price" class="form-control"
                            id="price">
                        <div class="form-text">Только сумма, без знака рубля. <i>(32000)</i></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание товара</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sale" class="form-label">Акция/скидка, в процентах товара</label>
                        <input type="number" value="{{ old('sale') }}" name="sale" class="form-control"
                            id="sale">
                        <div class="form-text">Если акции нет, оставьте поле пустым.</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="brand" class="form-label">Бренд товара</label>
                        <select required class="form-select" name="brand" id="brand"
                            aria-label="Default select example">
                            <option selected value="">-</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Бренд обязательное поле, если нужного бренда нет, добавьте его
                            самостоятельно.</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="count" class="form-label">Количество товара</label>
                        <input required type="number" value="{{ old('count') }}" name="count" class="form-control"
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

                    <div id="image-preview">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="parent" class="form-label">Категоия товара</label>
                        <select required class="form-select" name="parent" id="parent">
                            <option value="">-</option>
                            @foreach ($categories as $category)
                                <option @if (old('parent') == $category->id) selected @endif
                                    data-attributes="{{ $category->parentAttributes }}" value="{{ $category->id }}">
                                    {{ $category->title }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Характеристики категории и родительских категорий будут применены к товару.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add-attribute" class="form-label">Характеристики товара</label>
                        <div id="attribute-list">

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
                            
                        </div>
                    </div>
                </div>
                {{-- <div class="col-sm-8"></div> --}}
                <div class="col-sm-12">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Создать товар</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
