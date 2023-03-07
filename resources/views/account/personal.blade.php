@extends('layouts.account')

@section('title')
    Профиль - {{ Auth::user()->name }}
@endsection



@section('account.main')
    <div class="container my-5">
        <h1>Персональные данные </h1>
        <div class="row gy-4 mt-4">
            <div class="col-md-5">
                <form method="POST" action="{{ route('core.account.edit.information') }}">
                    @csrf
                    @if (session()->has('success') && session()->get('for') == 'personal')
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if ($errors->any() && $errors->first('personal'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    @if ($error == 1)
                                        @continue
                                    @endif
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="email" class="form-label">Электронная почта</label>
                        <input required type="email" name="email" value="{{ Auth::user()->email }}" class="form-control"
                            id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input required type="text" name="name" value="{{ Auth::user()->name }}" class="form-control"
                            id="name">
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Фамилия</label>
                        <input required type="text" name="surname" value="{{ Auth::user()->surname }}"
                            class="form-control" id="surname">
                    </div>
                    <button type="reset" class="btn btn-warning">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <form method="post" action="{{ route('core.account.edit.password') }}">
                    @csrf
                    @if (session()->has('success') && session()->get('for') == 'password')
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if ($errors->any() && $errors->first('password'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    @if ($error == 1)
                                        @continue
                                    @endif
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Старый пароль</label>
                        <input type="password" name="oldPassword" class="form-control" id="oldPassword"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Новый пароль</label>
                        <input type="password" name="newPassword" class="form-control" id="newPassword">
                    </div>
                    <div class="mb-3">
                        <label for="confirmNewPassword" class="form-label">Подтверждение пароля</label>
                        <input type="password" name="confirmNewPassword" class="form-control" id="confirmNewPassword">
                    </div>
                    <button type="reset" class="btn btn-warning">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
                <div class="mt-4">
                    <p>Если вы забыли свой старый пароль восстановите его <a href="">здесь</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
