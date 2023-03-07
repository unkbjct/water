@extends('layouts.main')

@section('main')
    <section class="bg-secondary-subtle pt-4">
        <div class="container">
            <h2>{{ Auth::user()->name }} - Администратор</h2>
            <ul class="nav account-menu mt-4">
                <li class="nav-item">
                    <a href="{{ route('admin.products') }}" class="nav-link @if (str_contains(Request::route()->getName(), 'products')) active @endif"
                        aria-current="page">Товары</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories') }}" class="nav-link @if (str_contains(Request::route()->getName(), 'categories')) active @endif"
                        aria-current="page">Категории</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.brands') }}" class="nav-link @if (str_contains(Request::route()->getName(), 'brands')) active @endif"
                        aria-current="page">Бренды</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders') }}" class="nav-link @if (str_contains(Request::route()->getName(), 'orders')) active @endif"
                        aria-current="page">Заказы</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.transactions') }}" class="nav-link @if (str_contains(Request::route()->getName(), 'transactions')) active @endif"
                        aria-current="page">Транзакции</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link @if (str_contains(Request::route()->getName(), 'users')) active @endif"
                        aria-current="page">Пользователи</a>
                </li>
            </ul>
        </div>
    </section>
    <section>
        @yield('admin.main')
    </section>
@endsection
