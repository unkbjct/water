@extends('layouts.admin')

@section('adds-component')
    <link rel="stylesheet" href="{{ asset('public/css/admin/categories.css') }}">
    <script src="{{ asset('public/js/admin/brands.js') }}"></script>
@endsection

@section('admin.main')
    <div class="container my-5 collapse" id="collapseCreate">
        <div class="d-flex">
            <h2>Создание нового бренда</h2>
            <button class="btn-close ms-auto" data-bs-target="#collapseCreate" data-bs-toggle="collapse"></button>
        </div>
        <form action="{{ route('core.admin.brands.create') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name-create" class="form-label">Название</label>
                <input required type="text" class="form-control" name="name" id="name-create">
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
    <div class="container my-5 collapse" id="collapseChange">
        <div class="d-flex">
            <h2>Изменение бренда</h2>
            <button class="btn-close ms-auto" data-bs-target="#collapseChange" data-bs-toggle="collapse"></button>
        </div>
        <form action="{{ route('core.admin.brands.change') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="hidden" name="id" id="id-change">
                <label for="name-change" class="form-label">Название</label>
                <input required type="text" class="form-control" name="name" id="name-change">
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>


    <section class="container my-5">
        <form action="{{ route('admin.brands') }}" method="get">
            <div class="row gy-4 mb-4">
                <div class="col-lg-1">
                    <div class="sort">
                        <label for="id" class="form-label">Номер</label>
                        <input type="text" value="{{ old('id') }}" name="id" id="id"
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort">
                        <label for="name" class="form-label">Название</label>
                        <input type="text" value="{{ old('name') }}" name="name" id="name"
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort h-100 d-flex flex-column">
                        <div class="btn-group mt-auto">
                            <a href="{{ Route('admin.brands') }}" class="btn btn-secondary btn-sm">Сборсить</a>
                            <button type="submit" class="btn btn-success btn-sm">Применить</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5"></div>
                <div class="col-lg-2">
                    <div class="h-100 d-flex flex-column">
                        <a href="#collapseCreate" data-bs-toggle="collapse" class="btn btn-warning btn-sm mt-auto">Добавить
                            новый бренд</a>
                    </div>
                </div>
            </div>
        </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Дата добавления</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($brands as $brand)
                    <tr>
                        <th scope="row">{{ $brand->id }}</th>
                        <td>
                            {{ $brand->name }}
                        </td>
                        <td>
                            {{ $brand->created_at }}
                        </td>
                        <td class="d-flex">
                            <div class="btn-group  ms-auto" data-brand="{{ $brand }}">
                                <button class="btn btn-remove-modal btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#removeBrandModal">Удалить</button>
                                <button data-bs-toggle="collapse" data-bs-target="#collapseChange"
                                    class="btn btn-change btn-warning btn-sm">Изменить</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="fs-5 text-center py-5">По заданным фильтрам ничего не найдено</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <div class="modal fade" id="removeBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Подтвердите дейстиве</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Вы действительно хотите удалить бренд: <b id="currentBrand"></b>
                </div>
                <form action="{{ route('core.admin.brands.remove') }}" method="POST" class="btn-group w-100">
                    @csrf
                    <input type="hidden" name="id" id="id-remove">
                    <button type="button" class="btn rounded-top-0 btn-secondary"
                        data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn rounded-top-0 btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
