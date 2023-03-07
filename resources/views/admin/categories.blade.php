@extends('layouts.admin')

@section('adds-component')
    <link rel="stylesheet" href="{{ asset('public/css/admin/categories.css') }}">
@endsection

@section('admin.main')
    <section class="container my-5">
        <form action="{{ route('admin.categories') }}" method="get">
            <div class="row gy-4 mb-4">
                <div class="col-lg-1">
                    <div class="sort">
                        <label for="id" class="form-label">Номер</label>
                        <input type="text" value="{{ old('id') }}" name="id" id="id  "
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" value="{{ old('title') }}" name="title" id="title"
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort h-100 d-flex flex-column">
                        <div class="btn-group mt-auto">
                            <a href="{{ Route('admin.categories') }}" class="btn btn-secondary btn-sm">Сборсить</a>
                            <button type="submit" class="btn btn-success btn-sm">Применить</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5"></div>
                <div class="col-lg-2">
                    <div class="h-100 d-flex flex-column">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-warning btn-sm mt-auto">Новая
                            категория</a>
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Родительская категория</th>
                    <th scope="col">Дата добавления</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->id }}</th>
                        <td><a
                                href="{{ route('admin.categories.edit', ['category' => $category->id]) }}">{{ $category->title }}</a>
                        </td>
                        <td>
                            @if ($category->parent_id)
                                <a
                                    href="{{ route('admin.categories.edit', ['category' => $category->parent_id]) }}">{{ $category->parent_title }}</a>
                            @else
                                {{ $category->parent_title }}
                            @endif
                        </td>
                        <td>{{ $category->created_at }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="fs-5 text-center py-5">По заданным фильтрам ничего не найдено</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
    <section class="container my-5">
        <div class="d-flex justify-content-between align-items-cetner mb-3">
            <h2>Дерево категорий</h2>
            <div>
                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse"
                    data-bs-target=".multi-collapse">Показать/Скрыть все</button>
            </div>
        </div>
        <div class="categoies-tree">
            @each('components.category', $treeCategories, 'category')
        </div>
    </section>
@endsection
