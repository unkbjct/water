@extends('layouts.main')

@section('title')
    Авторизация
@endsection

@section('main')
    <section class="container">
        <div class="mx-auto mb-5" style="max-width: 700px">
            <form method="POST" action="{{ route('core.account.signUp') }}"
                class="mt-5 mb-3 bg-secondary-subtle p-4 shadow-sm rounded" action="">
                @csrf
                <h1 class="mb-5">Создание нового пользователя</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="email" class="form-label">Электронная почта *</label>
                    {{-- <h1>{{$input}}</h1> --}}
                    <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="email">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Имя *</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name">
                </div>
                <div class="mb-3">
                    <label for="surnamed" class="form-label">Фамилия *</label>
                    <input type="text" class="form-control" value="{{ old('surname') }}" name="surname" id="surname">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль *</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Подтверждение пароля *</label>
                    <input type="password" class="form-control" name="confirmPassword" id="confirm-password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="personalData" id="personal-data">
                    <label class="form-check-label" for="personal-data">Я даю согласие на обработку персональных
                        данных</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="pilitics" id="pilitics">
                    <label class="form-check-label" for="pilitics">Я ознакомился и согласен с <a href="">политикой
                            конфидециальности</a>, <a href="">Публичной офертой для физических лиц</a>.</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Создать аккаунт</button>
                </div>
                <p class="text-muted">* - Обязательные поля для заполнения</p>
            </form>
            <p>Если у Вас уже есть аккаунт, войдите в него <a href="{{ route('account.login') }}">здесь</a>.</p>
        </div>
    </section>
@endsection
