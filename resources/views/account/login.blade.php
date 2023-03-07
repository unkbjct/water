@extends('layouts.main')

@section('title')
    Авторизация
@endsection

@section('main')
    <section class="container">
        <div class="mx-auto" style="max-width: 700px">
            <form method="POST" action="{{ route('core.account.login') }}"
                class="mt-5 mb-3 bg-secondary-subtle mx-auto p-4 shadow-sm rounded">
                @csrf
                <h1 class="mb-5">Авторизация</h1>
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
                    <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль *</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" @if(old('remember')) checked @endif name="remember" id="remember">
                    <label class="form-check-label" for="remember">Оставаться авторизованным</label>
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
            <p>Если у Вас еще нет аккаунта, создайте его <a href="{{ route('account.signUp') }}">здесь</a>.</p>

        </div>
    </section>
@endsection
