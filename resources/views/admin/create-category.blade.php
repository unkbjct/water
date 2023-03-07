@extends('layouts.admin')

@section('adds-component')
    <script src="{{ asset('public/js/admin/categories.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/css/admin/categories.css') }}">
@endsection

@section('admin.main')
    <section class="container my-5">
        @if (Request::route()->getName() == 'admin.categories.create')
            <form method="POST" action="{{ route('core.admin.categories.create') }}">
                <h2 class="mb-4">Создание новой категории</h2>
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
                            <label for="titleRus" class="form-label">Название категории (Русский)</label>
                            <input required type="text" value="{{ old('titleRus') }}" name="titleRus"
                                class="form-control" id="titleRus">
                            <div class="form-text">Будет отображатся пользователям, <i>(душ)</i>.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="titleEng" class="form-label">Название категории (Английский) </label>
                            <input required type="text" value="{{ old('titleEng') }}" name="titleEng"
                                class="form-control" id="titleEng">
                            <div class="form-text">Будет использоваться для ссылок, <i>(dysh)</i>.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="parent" class="form-label">Родительская категоия </label>
                            <select class="form-select" name="parent" id="parent">
                                <option value="">-</option>
                                @foreach ($categories as $category)
                                    <option @if (old('parent') == $category->id) selected @endif
                                        data-attributes="{{ $category->parentAttributes }}" value="{{ $category->id }}">
                                        {{ $category->title }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Новая категория и товары данной категории будут содержать
                                характеристики родительских категорий. Ничего не выбирайте если нет родительской категории
                                или
                                она не нужна.</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="add-attribute" class="form-label">Характеристики категории</label>
                            <div class="input-group mb-3">
                                <input type="text" id="add-attribute" class="form-control">
                                <button class="btn btn-warning" type="button" id="btn-add-attribute">Добавить</button>
                            </div>
                            <div id="attribute-list">
                                @if (old('attributes'))
                                    @foreach (old('attributes') as $attribute)
                                        <div class="attributes-item">
                                            <div class="me-4"> {{ $attribute }} </div>
                                            <input type="hidden" value="{{ $attribute }}"
                                                name="attributes[{{ $attribute }}]">
                                            <button type="button" class="btn-remove-attribute btn-close"
                                                aria-label="Close"></button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-text">Характеристики в синий рамке не могут быть удалены, так как принадлежат
                                родительским категориям.</div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-8"></div> --}}
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Добавить категорию</button>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <form method="POST" action="{{ route('core.admin.categories.edit', ['category' => $thisCategory->id]) }}">
                <div class="d-flex align-items-start justify-content-between lh-1">
                    <h2 class="mb-4">Категория: {{ $thisCategory->title }}</h2>
                    <p>Дата последнего изменения: {{ $thisCategory->updated_at }}</p>
                </div>
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
                            <label for="titleRus" class="form-label">Название категории (Русский)</label>
                            <input required type="text" value="{{ $thisCategory->title }}" name="titleRus"
                                class="form-control" id="titleRus">
                            <div class="form-text">Будет отображатся пользователям, <i>(душ)</i>.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="titleEng" class="form-label">Название категории (Английский) </label>
                            <input required type="text" value="{{ $thisCategory->title_eng }}" name="titleEng"
                                class="form-control" id="titleEng">
                            <div class="form-text">Будет использоваться для ссылок, <i>(dysh)</i>.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="parent" class="form-label">Родительская категоия </label>
                            <select class="form-select" name="parent" id="parent">
                                <option value="">-</option>
                                @foreach ($categories as $category)
                                    <option @if ($thisCategory->parent_id == $category->id) selected @endif
                                        data-attributes="{{ $category->parentAttributes }}" value="{{ $category->id }}">
                                        {{ $category->title }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"><i>Та же самая категория и ее дети не могут быть выбраны как
                                    родительские.</i>
                                Новая категория и товары данной категории будут содержать
                                характеристики родительских категорий. Ничего не выбирайте если нет родительской категории
                                или
                                она не нужна.</div>
                            <div class="form-text">Если у категории имеются дочерние категории и вы измените родительскую
                                категорию, все характеристики дочерних категорий тоже изменятся </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="add-attribute" class="form-label">Характеристики категории</label>
                            <div class="input-group mb-3">
                                <input type="text" id="add-attribute" class="form-control">
                                <button class="btn btn-warning" type="button" id="btn-add-attribute">Добавить</button>
                            </div>
                            <div id="attribute-list" data-this-attributes="{{ $thisCategory->attributes }}">
                                @if (old('attributes'))
                                    @foreach (old('attributes') as $attribute)
                                        <div class="attributes-item">
                                            <div class="me-4"> {{ $attribute }} </div>
                                            <input type="hidden" value="{{ $attribute }}"
                                                name="attributes[{{ $attribute }}]">
                                            <button type="button" class="btn-remove-attribute btn-close"
                                                aria-label="Close"></button>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($thisCategory->attributes as $attribute)
                                        <div class="attributes-item">
                                            <div class="me-4"> {{ $attribute->name }} </div>
                                            <input type="hidden" value="{{ $attribute->name }}"
                                                name="attributes[{{ $attribute->name }}]">
                                            <button type="button" class="btn-remove-attribute btn-close"
                                                aria-label="Close"></button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-text">Характеристики в синий рамке не могут быть удалены, так как принадлежат
                                родительским категориям.</div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-8"></div> --}}
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap">
                            <a href="{{ route('admin.categories') }}" class="btn btn-secondary me-auto">Вернуться
                                назад</a>
                            <button type="reset" id="btn-reset" class="btn btn-secondary me-4">Отмена</button>
                            <button type="button" class="btn btn-danger me-4" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Удалить категорию</button>
                            <button type="submit" class="btn btn-primary">Сохранить категорию</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Подтвердите действие</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <P>Вы действительно хотите удалить категортю: <b>{{ $thisCategory->title }}</b></P>
                            <P class="text-danger">При удаление категории все дочерние категории и продкуты входящие в эти
                                категории будут удалены!!!</P>
                        </div>
                        <form method="POST" class="w-100"
                            action="{{ route('core.admin.categories.remove', ['category' => $thisCategory->id]) }}">
                            @csrf
                            <div class="btn-group w-100">
                                <button type="button" class="btn rounded-top-0  btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn rounded-top-0  btn-danger">Удалить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
