@extends('layouts.main')

@section('title')
    Избранные товары
@endsection

@section('adds-component')
    <link rel="stylesheet" href="{{ asset('public/css/filter.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection


@section('main')
    <section class="bg-secondary-subtle py-5">
        <div class="container">
            <h2>Избранные товары</h2>
        </div>
    </section>
    <div class="container my-5">
        <div class="d-flex flex-wrap">

            @if (!isset($products) || $products->isEmpty())
                <div class="my-5 mx-auto text-muted">
                    <h2>У вас нет избранных товаров</h2>
                </div>
            @else
                @foreach ($products as $prod)
                    <div class="product-item">
                        <div style="height: 300px; overflow: hidden" class="d-flex justify-content-center rounded">
                            <img class="h-100 w-100 mx-auto preview" src="{{ asset($prod->images[0]->url) }}"
                                alt="">
                        </div>
                        <div class="price d-flex my-3">
                            @if ($prod->sale)
                                <div class="fresh-price">
                                    <span
                                        class="fresh-current-price">{{ number_format($prod->price - $prod->price * ($prod->sale / 100), 0, ',', ' ') }}</span>
                                    ₽.
                                </div>
                                <div class="old-price"><span
                                        class="old-current-price">{{ number_format($prod->price, 0, ',', ' ') }}</span> ₽.
                                </div>
                                <span class="badge text-bg-danger ms-auto">-{{ $prod->sale }}%</span>
                            @else
                                <div class="fresh-price">
                                    <span class="fresh-current-price">{{ number_format($prod->price, 0, ',', ' ') }}</span>
                                    ₽.
                                </div>
                            @endif
                        </div>
                        <div class="title">{{ $prod->title }}</div>
                        <div class="rating d-flex">
                            <div class="me-3">
                                <span class="fa fa-star @if ($prod->rating >= 1) checked @endif "></span>
                                <span class="fa fa-star @if ($prod->rating >= 2) checked @endif "></span>
                                <span class="fa fa-star @if ($prod->rating >= 3) checked @endif "></span>
                                <span class="fa fa-star @if ($prod->rating >= 4) checked @endif "></span>
                                <span class="fa fa-star @if ($prod->rating >= 5) checked @endif "></span>
                            </div>
                            <span>
                                @if ($prod->rating)
                                    {{ $prod->rating }} отзывов
                                @else
                                    нет отзывов
                                @endif
                            </span>
                        </div>
                        <div class="btns">
                            <a href="{{ route('product', ['product' => $prod->id]) }}"
                                class="btn btn-warning me-2 btn-sm w-100">Подробнее</a>
                            <a href="{{ route('account.favorites') }}">
                                <div class="add-to-favorites @if (isset($_COOKIE['favorites']) && in_array($prod->id, explode(',', $_COOKIE['favorites']))) activeFavorite @endif"
                                    data-product="{{ $prod }}">
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M462.1 62.86C438.8 41.92 408.9 31.1 378.7 32c-37.49 0-75.33 15.4-103 43.98l-19.7 20.27l-19.7-20.27C208.6 47.4 170.8 32 133.3 32C103.1 32 73.23 41.93 49.04 62.86c-62.14 53.79-65.25 149.7-9.23 207.6l193.2 199.7C239.4 476.7 247.6 480 255.9 480c8.332 0 16.69-3.267 23.01-9.804l193.1-199.7C528.2 212.5 525.1 116.6 462.1 62.86zM437.6 237.1l-181.6 187.8L74.34 237.1C42.1 203.8 34.46 138.1 80.46 99.15c39.9-34.54 94.59-17.5 121.4 10.17l54.17 55.92l54.16-55.92c26.42-27.27 81.26-44.89 121.4-10.17C477.1 138.6 470.5 203.1 437.6 237.1z" />
                                        <path fill="#fff" class="filledFavorite"
                                            d="M429.9,95.6c-40.4-42.1-106-42.1-146.4,0L256,124.1l-27.5-28.6c-40.5-42.1-106-42.1-146.4,0c-45.5,47.3-45.5,124.1,0,171.4   L256,448l173.9-181C475.4,219.7,475.4,142.9,429.9,95.6z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
@endsection
