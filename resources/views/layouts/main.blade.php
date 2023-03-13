<?
$navList = App\Models\Category::where("depth", "=", "1")->get();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="{{ asset('public/js/main.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/css/main.css') }}">
    @yield('adds-component')

</head>

<body>
    <div class="wrapper">
        <header class="bg-body-tertiary">
            <div id="catalog-nav" class="catalog-nav collapse">
                <div class="container p-4">
                    <div class="d-flex justify-content-between">
                        <h2 class="mb-5">Каталог</h2>
                        <button type="button" id="close-catalog-nav" class="btn-close" data-bs-toggle="collapse"
                            data-bs-target="#catalog-nav"></button>
                    </div>
                    <div class="catalog-nav-list">
                        @foreach ($navList as $navItem)
                            <a class="catalog-nav-link"
                                href="{{ route('catalog.search', ['category' => $navItem->title_eng]) }}">
                                <div class="catalog-nav-item">
                                    {{ $navItem->title }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <nav class="navbar navbar-expand-xl">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <svg wifth="40px" height="40px" id="filled" viewBox="0 0 64 64"
                            xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: #fff;
                                    }

                                    .cls-1,
                                    .cls-2,
                                    .cls-3 {
                                        stroke: #000;
                                        stroke-linecap: round;
                                        stroke-linejoin: round;
                                        stroke-width: 2px;
                                    }

                                    .cls-2 {
                                        fill: #bdc3c7;
                                    }

                                    .cls-3 {
                                        fill: #004fe3;
                                    }
                                </style>
                            </defs>
                            <rect class="cls-1" height="16" transform="translate(114 70) rotate(-180)"
                                width="6" x="54" y="27" />
                            <rect class="cls-1" height="12" transform="translate(66 40) rotate(-180)" width="4"
                                x="31" y="14" />
                            <path class="cls-2"
                                d="M25,30l.1026-.3079A8.3246,8.3246,0,0,1,33,24h0a8.3246,8.3246,0,0,1,7.8974,5.6921L41,30H54V40H41l-.1026.3079A8.3246,8.3246,0,0,1,33,46h0a8.3246,8.3246,0,0,1-7.8974-5.6921L25,40H16a2,2,0,0,0-2,2v8H6V40A10,10,0,0,1,16,30Z" />
                            <rect class="cls-1" height="4" transform="translate(20 104) rotate(-180)"
                                width="12" x="4" y="50" />
                            <path class="cls-3"
                                d="M46.9731,13.1259C46.6841,8.4636,44,8,41.6236,8.69A33.3294,33.3294,0,0,1,33,9.8251,33.3294,33.3294,0,0,1,24.3764,8.69C22,8,19.3159,8.4636,19.0269,13.1259Q19,13.556,19,14H47Q47,13.5565,46.9731,13.1259Z" />
                        </svg>
                    </a>
                    <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse mobile-border-bottom" id="navbarSupportedContent">
                        <ul class="navbar-nav w-100 mb-2 mb-lg-0">
                            <li class="nav-item me-3 d-flex align-items-center">
                                <button type="button" data-bs-toggle="collapse" data-bs-target="#catalog-nav"
                                    id="show-catalog-nav" class="btn btn-primary ">
                                    <div class="d-flex align-items-center">
                                        <svg fill="#fff" class="me-2" height="20px" id="Layer_1"
                                            style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32"
                                            width="20px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <path
                                                d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2  s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2  S29.104,22,28,22z" />
                                        </svg>
                                        <span>Каталог</span>
                                    </div>
                                </button>
                            </li>
                            <li class="nav-item d-flex align-items-center me-5 w-100">
                                <form class="d-flex w-100"
                                    action="{{ route('catalog.search', ['category' => 'santehnika']) }}" role="search">
                                    <div class="input-group">
                                        <input type="search" class="border-primary form-control"
                                            placeholder="Быстрый поиск" name="title">
                                        <button class="btn btn-primary d-flex align-items-center" type="submit"
                                            id="button-addon2">
                                            <svg fill="#fff" width="20px" height="20px"
                                                enable-background="new 0 0 32 32" id="Glyph" version="1.1"
                                                viewBox="0 0 32 32" xml:space="preserve"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <path
                                                    d="M27.414,24.586l-5.077-5.077C23.386,17.928,24,16.035,24,14c0-5.514-4.486-10-10-10S4,8.486,4,14  s4.486,10,10,10c2.035,0,3.928-0.614,5.509-1.663l5.077,5.077c0.78,0.781,2.048,0.781,2.828,0  C28.195,26.633,28.195,25.367,27.414,24.586z M7,14c0-3.86,3.14-7,7-7s7,3.14,7,7s-3.14,7-7,7S7,17.86,7,14z"
                                                    id="XMLID_223_" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </li>
                            <li class="nav-item" style="width: fit-content">
                                @if (Auth::check())
                                    <a href="{{ route('account.personal') }}" class="nav-link">
                                        <div class="item-menu">
                                            <div class="d-flex justify-content-center">
                                                <svg fill="#0d6efd" width="25px" height="25px"
                                                    viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                    <title />
                                                    <g data-name="user people person users man"
                                                        id="user_people_person_users_man">
                                                        <path
                                                            d="M23.74,16.18a1,1,0,1,0-1.41,1.42A9,9,0,0,1,25,24c0,1.22-3.51,3-9,3s-9-1.78-9-3a9,9,0,0,1,2.63-6.37,1,1,0,0,0,0-1.41,1,1,0,0,0-1.41,0A10.92,10.92,0,0,0,5,24c0,3.25,5.67,5,11,5s11-1.75,11-5A10.94,10.94,0,0,0,23.74,16.18Z" />
                                                        <path
                                                            d="M16,17a7,7,0,1,0-7-7A7,7,0,0,0,16,17ZM16,5a5,5,0,1,1-5,5A5,5,0,0,1,16,5Z" />
                                                    </g>
                                                </svg>
                                            </div>
                                            <span style="font-size: 14px;">{{ Auth::user()->name }}</span>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('account.login') }}" class="nav-link">
                                        <div class="item-menu">
                                            <div class="d-flex justify-content-center">
                                                <svg fill="#0d6efd" width="25px" height="25px"
                                                    viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                    <title />
                                                    <g data-name="user people person users man"
                                                        id="user_people_person_users_man">
                                                        <path
                                                            d="M23.74,16.18a1,1,0,1,0-1.41,1.42A9,9,0,0,1,25,24c0,1.22-3.51,3-9,3s-9-1.78-9-3a9,9,0,0,1,2.63-6.37,1,1,0,0,0,0-1.41,1,1,0,0,0-1.41,0A10.92,10.92,0,0,0,5,24c0,3.25,5.67,5,11,5s11-1.75,11-5A10.94,10.94,0,0,0,23.74,16.18Z" />
                                                        <path
                                                            d="M16,17a7,7,0,1,0-7-7A7,7,0,0,0,16,17ZM16,5a5,5,0,1,1-5,5A5,5,0,0,1,16,5Z" />
                                                    </g>
                                                </svg>
                                            </div>
                                            <span style="font-size: 14px;">Войти</span>
                                        </div>
                                    </a>
                                @endif
                            </li>
                            <li class="nav-item" style="width: fit-content">
                                <a href="{{ route('account.favorites') }}" class="nav-link">
                                    <div class="item-menu position-relative">
                                        <div class="d-flex justify-content-center">
                                            <svg fill="#0d6efd" width="25px" height="25px"
                                                enable-background="new 0 0 32 32" id="Layer_1" version="1.1"
                                                viewBox="0 0 32 32" xml:space="preserve"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <g>
                                                    <polyline fill="none"
                                                        points="   649,137.999 675,137.999 675,155.999 661,155.999  "
                                                        stroke="#FFFFFF" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-miterlimit="10"
                                                        stroke-width="2" />
                                                    <polyline fill="none"
                                                        points="   653,155.999 649,155.999 649,141.999  "
                                                        stroke="#FFFFFF" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-miterlimit="10"
                                                        stroke-width="2" />
                                                    <polyline fill="none" points="   661,156 653,162 653,156  "
                                                        stroke="#FFFFFF" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-miterlimit="10"
                                                        stroke-width="2" />
                                                </g>
                                                <g>
                                                    <g>
                                                        <path
                                                            d="M16,30c-0.215,0-0.43-0.069-0.61-0.207C14.844,29.372,2,19.396,2,11c0-4.411,3.589-8,8-8s8,3.589,8,8c0,0.552-0.447,1-1,1    c-0.552,0-1-0.448-1-1c0-3.309-2.691-6-6-6s-6,2.691-6,6c0,6.467,9.477,14.653,12,16.719C18.522,25.653,28,17.46,28,11    c0-3.309-2.691-6-6-6c-0.895,0-1.756,0.192-2.559,0.57c-0.5,0.236-1.097,0.021-1.331-0.478c-0.235-0.5-0.021-1.095,0.478-1.331    C19.66,3.256,20.808,3,22,3c4.411,0,8,3.589,8,8c0,8.396-12.844,18.372-13.39,18.793C16.43,29.931,16.215,30,16,30z" />
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <span id="favoriute-count"
                                            class="@if (!isset($_COOKIE['favorites']) || !(bool) $_COOKIE['favorites']) visually-hidden @endif position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                                            @if (isset($_COOKIE['favorites']))
                                                {{ sizeof(explode(',', $_COOKIE['favorites'])) }}
                                            @endif
                                        </span>
                                        <span style="font-size: 14px;">Избранное</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" style="width: fit-content">
                                <a href="" class="nav-link" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasCartList">
                                    <div class="item-menu position-relative">
                                        <div class="d-flex justify-content-center">
                                            <svg stroke="#0d6efd" width="25px" height="25px"
                                                viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
                                                <rect fill="none" />
                                                <path d="M184,184H69.8L41.9,30.6A8,8,0,0,0,34.1,24H16" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="16" />
                                                <circle cx="80" cy="204" fill="none" r="20"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="16" />
                                                <circle cx="184" cy="204" fill="none" r="20"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="16" />
                                                <path d="M62.5,144H188.1a15.9,15.9,0,0,0,15.7-13.1L216,64H48"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="16" />
                                            </svg>
                                        </div>
                                        @if (Cookie::get('cart'))
                                            <span id="favoriute-count"
                                                class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-warning">
                                                {{ sizeof(json_decode(Cookie::get('cart'))) }}
                                            </span>
                                        @endif
                                        <span style="font-size: 14px;">Корзина</span>
                                    </div>
                                </a href="">
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <nav class="navbar navbar-expand-xl p-0">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item d-flex">
                                <a class="nav-link" style="font-size: 14px;"
                                    href="{{ route('information') }}#mobile">Мобильное приложение</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="font-size: 14px;"
                                    href="{{ route('information') }}#shops">Магазины</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="font-size: 14px;"
                                    href="{{ route('information') }}#contacts">Контакты</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" style="font-size: 14px;" href="#">О компании</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" style="font-size: 14px;" href="{{route('brands')}}">Бренды</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>


        <main>
            @yield('main')


            <div class="offcanvas offcanvas-end @if ($errors->any() && $errors->first('showCart')) show @endif" tabindex="-1"
                id="offcanvasCartList">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasRightLabel">Корзина</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-flex flex-column">
                    @if (Cookie::get('cart'))
                        <div class="cart-list">
                            @foreach (json_decode(Cookie::get('cart')) as $cartItem)
                                <div class="cart-item border">
                                    <div class="cart-img">
                                        <img src="{{ asset($cartItem->image) }}" class="h-100">
                                    </div>
                                    <div class="cart-info w-100">
                                        <div class="cart-title">
                                            <p class="fw-semibold">{{ $cartItem->title }}</p>
                                        </div>
                                        <div class="d-flex">
                                            <div>
                                                <div>
                                                    {{ number_format(($cartItem->price - $cartItem->price * ($cartItem->sale / 100)) * $cartItem->count, 0, ',', ' ') }}
                                                    ₽.</div>
                                                <div>{{ $cartItem->count }} шт.</div>
                                            </div>
                                            <div class="ms-auto">
                                                <div class="input-group text-center">
                                                    <form
                                                        action="{{ route('product.cart.remove', ['product' => $cartItem->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <button class="btn btn-outline-secondary btn-sm"
                                                            style="width: 32px">-</button>
                                                    </form>
                                                    <input disabled value="{{ $cartItem->count }}" type="text"
                                                        class="form-control form-control-sm text-center"
                                                        style="width: 40px">
                                                    <form method="POST"
                                                        action="{{ route('product.cart.add', ['product' => $cartItem->id]) }}">
                                                        @csrf
                                                        <button class="btn btn-outline-secondary btn-sm"
                                                            style="width: 32px">+</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-auto d-flex">
                            <a href="{{ route('order') }}" class="btn mx-auto btn-warning btn-sm">Оформить заказ</a>
                        </div>
                    @else
                        <div class="my-auto text-center">
                            <div class="text muted">На данный момент ваша коризна пустая!</div>
                            <div class="text muted">Перейдит в <a href="">каталог</a> чтобы добавить в нее
                                что-нибудь</div>
                        </div>
                    @endif
                </div>
            </div>
        </main>

        <footer class="bg-body-tertiary">
            <div class="container">
                <footer class="py-5">
                    <div class="row">
                        <div class="col-6 col-md-2 mb-3">
                            <h5>О нас</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">О
                                        компании</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Контакты</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Обратная
                                        связь</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Профессионалам</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Вакансии</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-6 col-md-2 mb-3">
                            <h5>Покупателям</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Мои
                                        заказы</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Доставка</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Магазины</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Пункты
                                        выдачи</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Оплата</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-6 col-md-2 mb-3">
                            <h5>Сервис</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Установка</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Бесплатное дизайн-решение</a></li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Ускоренная доставка</a></li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Распродажа</a>
                                </li>
                                <li class="nav-item mb-2"><a href="#"
                                        class="nav-link p-0 text-muted">Уценка</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-5 offset-md-1 mb-3">
                            <form>
                                <h5>Подписывайтесь на наши новости</h5>
                                <p>Ежемесячный дайджест всего нового и интересного от нас.</p>
                                <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                                    <label for="newsletter1" class="visually-hidden">Электронная почта</label>
                                    <input id="newsletter1" type="text" class="form-control"
                                        placeholder="Электронная почта">
                                    <button class="btn btn-primary" type="button">Подписаться</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
                        <p>© 2022 СантехникаRu. Все права защищены.</p>
                        <ul class="list-unstyled d-flex">
                            <li class="ms-3"><a class="link-dark" href="#"><svg class="bi"
                                        width="24" height="24">
                                        <use xlink:href="#twitter"></use>
                                    </svg></a></li>
                            <li class="ms-3"><a class="link-dark" href="#"><svg class="bi"
                                        width="24" height="24">
                                        <use xlink:href="#instagram"></use>
                                    </svg></a></li>
                            <li class="ms-3"><a class="link-dark" href="#"><svg class="bi"
                                        width="24" height="24">
                                        <use xlink:href="#facebook"></use>
                                    </svg></a></li>
                        </ul>
                    </div>
                </footer>
            </div>
        </footer>
    </div>

</body>

</html>
