@extends('layouts.admin')

@section('title')
    Пользователи
@endsection

@section('admin.main')
    <div class="container mt-5">
        @if (session()->has('success'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        <form action="{{ route('admin.users') }}" method="get">
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
                        <label for="status" class="form-label">Роль</label>
                        <select name="status" id="status" class="form-select form-select-sm">
                            <option value="">Любая</option>
                            <option @if (old('status') === 'USER') selected @endif value="USER">Пользователь</option>
                            <option @if (old('status') === 'ADMIN') selected @endif value="ADMIN">Администратор</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort">
                        <label for="email" class="form-label">Почта</label>
                        <input type="text" value="{{ old('email') }}" name="email" id="email"
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort h-100 d-flex flex-column">
                        <div class="btn-group mt-auto">
                            <a href="{{ Route('admin.users') }}" class="btn btn-secondary btn-sm">Сборсить</a>
                            <button type="submit" class="btn btn-success btn-sm">Применить</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5"></div>
            </div>
        </form>
        <div class="my-3"><code>Вы можете изменить роль пользователя на администратора и наоборот</code></div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Роль</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Фамилия</th>
                    <th scope="col">email</th>
                    <th scope="col">Создан</th>
                    <th scope="col">Обновлен</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>
                            <form action="{{ route('core.admin.user.change', ['user' => $user->id]) }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <select class="form-select form-select-sm" name="status" id="status"
                                        aria-label="Example select with button addon">
                                        <option @if ($user->status == 'USER') selected @endif value="USER">
                                            Пользователь</option>
                                        <option @if ($user->status == 'ADMIN') selected @endif value="ADMIN">
                                            Администратор</option>
                                    </select>
                                    <button class="btn btn-warning btn-sm" type="submit">Сохранить</button>
                                </div>
                            </form>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="fs-5 text-center py-5">По заданным фильтрам ничего не найдено</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
