@extends('layouts.main')

@section('main')
    <section class="bg-secondary-subtle pt-5">
        <div class="container">
            <h2>{{ Auth::user()->surname }} {{ Auth::user()->name }}</h2>
            <p>{{ Auth::user()->email }}</p>
            <ul class="nav account-menu mt-5">
                <li class="nav-item">
                    <a href="{{ route('account.personal') }}" class="nav-link @if (Request::route()->getName() == 'account.personal') active @endif"
                        aria-current="page">Персональные данные</a>
                </li>
                @if (Auth::user()->status == 'ADMIN')
                    <li class="nav-item">
                        <a href="{{ route('admin.products') }}" class="nav-link" aria-current="page">Админ панель</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('account.history') }}"
                        class="nav-link @if (Request::route()->getName() == 'account.history') active @endif">История заказов</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('account.logout') }}" class="nav-link">Выйти</a>
                </li>
            </ul>
        </div>
    </section>
    <section>
        @yield('account.main')
    </section>
@endsection
