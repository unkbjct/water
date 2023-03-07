@extends('layouts.main')

@section('title')
    Оформление заказа
@endsection

{{-- <?dd()?> --}}

@section('adds-component')
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('main')
    <div class="custom-fade">
    </div>
    <div class="container mb-5">
        <section class="mt-4">
            <h2 class="my-0 me-3 lh-1 mb-5">Оформление заказа</h2>
            <div class="row gy-4">
                <div class="col-lg-8">
                    <form action={{ route('core.payment.create') }} method="POST">
                        @csrf
                        <div class="mb-4 p-3 shadow-sm border rounded">
                            <h4 class="mb-4">Персональный данные</h4>
                            <div class="row gy-4">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Имя:</label>
                                        <input required type="text" value="{{ Auth::user()->name }}" class="form-control"
                                            name="name" id="name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="surname" class="form-label">Фамилия:</label>
                                        <input required type="text" value="{{ Auth::user()->surname }}" class="form-control"
                                            name="surname" id="surname">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Электронная почта:</label>
                                        <input required type="email" value="{{ Auth::user()->email }}" class="form-control"
                                            name="email" id="email">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Телефон:</label>
                                        <input required type="text" class="form-control" name="phone" id="phone">
                                        {{-- <div class="form-text"></div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 p-3 shadow-sm border rounded">
                            <h4 class="mb-4">Адрес</h4>
                            <div class="row gy-4">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">Город:</label>
                                        <input required type="text" class="form-control" name="city" id="city">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="street" class="form-label">Улица:</label>
                                        <input required type="text" class="form-control" name="street" id="street">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label for="house" class="form-label">Дом:</label>
                                        <input required type="text" class="form-control" name="house" id="house">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label for="apart" class="form-label">Квартира:</label>
                                        <input required type="text" class="form-control" name="apart" id="apart">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label for="build" class="form-label">Корпус:</label>
                                        <input type="text" class="form-control" name="build" id="build">
                                        <div class="form-text">Если корпуса нет, ничего не пишите</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Комментарий к заказу:</label>
                                        <textarea name="comment" id="comment" class="form-control"></textarea>
                                        <div class="form-text">Можете оставить поле пустым</div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12"> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary ms-auto">Оплатить</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="p-3 rounded mb-4"
                        style="max-height: 400px; overflow: auto; box-shadow: inset 0 0 10px rgba(30, 30, 30, .2)">
                        @foreach ($cart as $cartItem)
                            <div class="cart-item border position-relative">
                                @if ($cartItem->sale)
                                    <span id="favoriute-count"
                                        class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger"
                                        style="top:20px!important; left:30px!important;">
                                        -{{ $cartItem->sale }} %
                                    </span>
                                @endif
                                <div class="cart-img">
                                    <img src="{{ asset($cartItem->image) }}" class="h-100">
                                </div>
                                <div class="cart-info">
                                    <div class="cart-title">
                                        <p class="fw-semibold">{{ $cartItem->title }}</p>
                                    </div>
                                    <div class="d-flex">
                                        @if ($cartItem->sale)
                                            <div>
                                                <span>{{ number_format(($cartItem->price - $cartItem->price * ($cartItem->sale / 100)) * $cartItem->count, 0, ',', ' ') }}
                                                    ₽.</span>
                                                <br>
                                                <span class="text-secondary"
                                                    style="text-decoration: line-through; font-size: 15px; margin-top: 10px">{{ number_format($cartItem->price * $cartItem->count, 0, ',', ' ') }}
                                                    ₽.</span>
                                            </div>
                                        @else
                                            <div>
                                                <span>{{ number_format($cartItem->price * $cartItem->count, 0, ',', ' ') }}
                                                    ₽.</span>
                                            </div>
                                        @endif
                                        <div class="ms-auto">
                                            <div class="input-group text-center">
                                                <form
                                                    action="{{ route('product.cart.remove', ['product' => $cartItem->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button class="btn btn-outline-secondary btn-sm rounded-end-0"
                                                        style="width: 32px">-</button>
                                                </form>
                                                <input disabled value="{{ $cartItem->count }}" type="text"
                                                    class="form-control form-control-sm text-center border" style="width: 30px">
                                                <form method="POST"
                                                    action="{{ route('product.cart.add', ['product' => $cartItem->id]) }}">
                                                    @csrf
                                                    <button class="btn btn-outline-secondary btn-sm rounded-start-0"
                                                        style="width: 32px">+</button>
                                                </form>
                                            </div>
                                            @if ($cartItem->count > 1)
                                                <div class="text-center text-secondary"
                                                    style="font-size: 12px; margin-top: 10px">
                                                    {{ number_format($cartItem->price - $cartItem->price * ($cartItem->sale / 100), 0, ',', ' ') }}/шт.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="list shadow-sm border rounded p-3">
                        <h3>Ваш заказ</h3>
                        <div class="d-flex justify-content-between mt-4">
                            <p class="text-secondary">Товары, {{ $fullCount }} шт.</p>
                            <p class="fw-semibold">{{ number_format($fullPrice, 0, ',', ' ') }} ₽.</p>
                        </div>
                        @if ($fullSale)
                            <div class="d-flex justify-content-between">
                                <p class="text-secondary">Скидки и акции</p>
                                <p class="fw-semibold text-warning">-{{ number_format($fullSale, 0, ',', ' ') }} ₽.</p>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mt-3">
                            <p class="fw-semibold">Итого</p>
                            <p class="fw-semibold">{{ number_format($fullPrice - $fullSale, 0, ',', ' ') }} ₽.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
