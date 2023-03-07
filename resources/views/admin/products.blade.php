@extends('layouts.admin')


@section('admin.main')
    <section class="container my-5">
        <form action="{{ route('admin.products') }}" method="get">
            <div class="row gy-4 mb-4">
                <div class="col-lg-1">
                    <div class="sort">
                        <label for="products_id" class="form-label">Номер</label>
                        <input type="text" value="{{ old('products_id') }}" name="products_id" id="products_id"
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort">
                        <label for="categories_title" class="form-label">категория</label>
                        <input type="text" value="{{ old('categories_title') }}" name="categories_title"
                            id="categories_title" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort">
                        <label for="products_title" class="form-label">Название</label>
                        <input type="text" value="{{ old('products_title') }}" name="products_title" id="products_title"
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort h-100 d-flex flex-column">
                        <div class="btn-group mt-auto">
                            <a href="{{ Route('admin.products') }}" class="btn btn-secondary btn-sm">Сборсить</a>
                            <button type="submit" class="btn btn-success btn-sm">Применить</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
                <div class="col-lg-2">
                    <div class="h-100 d-flex flex-column">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-warning btn-sm mt-auto">Добавить новый
                            товар</a>
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">категория</th>
                    <th scope="col">Название</th>
                    <th scope="col">цена (без скидки)</th>
                    <th scope="col">Дата добавления</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td scope="row">{{ $product->category }}</td>
                        <td><a
                                href="{{ route('admin.products.edit', ['product' => $product->id]) }}">{{ $product->title }}</a>
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="fs-5 text-center py-5">По заданным фильтрам ничего не найдено</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
