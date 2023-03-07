@extends('layouts.main')

@section('title')
    {{ config('app.name') }}
@endsection

@section('adds-component')
    <script src="{{ asset('public/js/swiper-element-bundle.min.js') }}"></script>
    <script src="{{ asset('public/js/welcome.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/css/welcome.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('public/css/swiper.min.css') }}"> --}}
@endsection

@section('main')
    <div class="container">
        <section id="slider" class="my-5 rounded overflow-hidden">
            <div id="pc-slider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="5000">
                        <a href=""><img class="w-100" src="{{ asset('public/storage/img/slider-pc/1.webp') }}"
                                alt=""></a>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <a href=""><img class="w-100" src="{{ asset('public/storage/img/slider-pc/2.webp') }}"
                                alt=""></a>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <a href=""><img class="w-100" src="{{ asset('public/storage/img/slider-pc/3.webp') }}"
                                alt=""></a>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <a href=""><img class="w-100" src="{{ asset('public/storage/img/slider-pc/4.webp') }}"
                                alt=""></a>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#pc-slider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#pc-slider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div id="mobile-slider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="5000">
                        <a href=""><img class="w-100" src="{{ asset('public/storage/img/slider-mob/1.webp') }}"
                                alt=""></a>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <a href=""><img class="w-100" src="{{ asset('public/storage/img/slider-mob/2.webp') }}"
                                alt=""></a>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <a href=""><img class="w-100" src="{{ asset('public/storage/img/slider-mob/3.webp') }}"
                                alt=""></a>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <a href=""><img class="w-100" src="{{ asset('public/storage/img/slider-mob/4.webp') }}"
                                alt=""></a>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mobile-slider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mobile-slider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        {{-- <section id="types" class="my-5">
            <h2 class="mb-4">Категории</h2>
            <swiper-container class="mySwiper" init="false" navigation="true">
                <swiper-slide>
                    <div class="card m-2 bg-body-tertiary text-center py-3 px-2" style="max-width: 150px">
                        <p>Смесители</p>
                        <img src="{{ asset('public/storage/img/types/krans.png') }}" alt="" class="w-100">
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="card m-2 bg-body-tertiary text-center py-3 px-2" style="max-width: 150px">
                        <p>Смесители</p>
                        <img src="{{ asset('public/storage/img/types/krans.png') }}" alt="" class="w-100">
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="card m-2 bg-body-tertiary text-center py-3 px-2" style="max-width: 150px">
                        <p>Смесители</p>
                        <img src="{{ asset('public/storage/img/types/krans.png') }}" alt="" class="w-100">
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="card m-2 bg-body-tertiary text-center py-3 px-2" style="max-width: 150px">
                        <p>Смесители</p>
                        <img src="{{ asset('public/storage/img/types/krans.png') }}" alt="" class="w-100">
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="card m-2 bg-body-tertiary text-center py-3 px-2" style="max-width: 150px">
                        <p>Смесители</p>
                        <img src="{{ asset('public/storage/img/types/krans.png') }}" alt="" class="w-100">
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="card m-2 bg-body-tertiary text-center py-3 px-2" style="max-width: 150px">
                        <p>Смесители</p>
                        <img src="{{ asset('public/storage/img/types/krans.png') }}" alt="" class="w-100">
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="card m-2 bg-body-tertiary text-center py-3 px-2" style="max-width: 150px">
                        <p>Смесители</p>
                        <img src="{{ asset('public/storage/img/types/krans.png') }}" alt="" class="w-100">
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="card m-2 bg-body-tertiary text-center py-3 px-2" style="max-width: 150px">
                        <p>Смесители</p>
                        <img src="{{ asset('public/storage/img/types/krans.png') }}" alt="" class="w-100">
                    </div>
                </swiper-slide>
                <swiper-slide>
                    <div class="card m-2 bg-body-tertiary text-center py-3 px-2" style="max-width: 150px">
                        <p>Смесители</p>
                        <img src="{{ asset('public/storage/img/types/krans.png') }}" alt="" class="w-100">
                    </div>
                </swiper-slide>
            </swiper-container>
        </section> --}}
        <section id="actions" class="my-5">
            <h2 class="mb-4">Акции</h2>
            <div class="row gy-4">
                <div class="col-md-4">
                    <div class="rounded overflow-hidden">
                        <a href="">
                            <img src="{{ asset('public/storage/img/actions/1.webp') }}" alt="" class="w-100">
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rounded overflow-hidden">
                        <a href="">
                            <img src="{{ asset('public/storage/img/actions/2.webp') }}" alt="" class="w-100">
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rounded overflow-hidden">
                        <a href="">
                            <img src="{{ asset('public/storage/img/actions/3.webp') }}" alt="" class="w-100">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section id="brands" class="my-5">
            <h2 class="mb-4">Популярные бренды</h2>
            <div class="row gy-4">
                <div class="col-md-3">
                    <div class="brand-card card">
                        <img class="brand-img" src="{{ asset('public/storage/img/brands/kludi-popular.svg') }}"
                            class="card-img-top" alt="...">
                        <div style="z-index: 10" class="card-body bg-white d-flex justify-content-between">
                            <img src="{{ asset('public/storage/img/brands/KLUDI.png') }}"
                                style="height: 30px;width: auto" class="card-img-top" alt="...">
                            <div class="see rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 30px; height: 30px">
                                <svg class="ms-1" height="65%" id="Layer_1"
                                    style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512"
                                    width="65%" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="brand-card card">
                        <img class="brand-img" src="{{ asset('public/storage/img/brands/hang-popular.png') }}"
                            class="card-img-top" alt="...">
                        <div style="z-index: 10" class="card-body bg-white d-flex justify-content-between">
                            <img src="{{ asset('public/storage/img/brands/hang.jpg') }}" style="height: 30px;width: auto"
                                class="card-img-top" alt="...">
                            <div class="see rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 30px; height: 30px">
                                <svg class="ms-1" height="65%" id="Layer_1"
                                    style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512"
                                    width="65%" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="brand-card card">
                        <img class="brand-img" src="{{ asset('public/storage/img/brands/nn-popular.png') }}"
                            class="card-img-top" alt="...">
                        <div style="z-index: 10" class="card-body bg-white d-flex justify-content-between">
                            <img src="{{ asset('public/storage/img/brands/nn.png') }}" style="height: 30px;width: auto"
                                class="card-img-top" alt="...">
                            <div class="see rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 30px; height: 30px">
                                <svg class="ms-1" height="65%" id="Layer_1"
                                    style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512"
                                    width="65%" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="brand-card card">
                        <img class="brand-img" src="{{ asset('public/storage/img/brands/vitra-popular.svg') }}"
                            class="card-img-top" alt="...">
                        <div style="z-index: 10" class="card-body bg-white d-flex justify-content-between">
                            <img src="{{ asset('public/storage/img/brands/vitra.png') }}"
                                style="height: 30px;width: auto" class="card-img-top" alt="...">
                            <div class="see rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 30px; height: 30px">
                                <svg class="ms-1" height="65%" id="Layer_1"
                                    style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512"
                                    width="65%" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="to-best-buys" class="my-5">
            <h2 class="mb-4">Для комфортной покупки</h2>
            <div class="row gy-4">
                <div class="col-xl-4">
                    <div class="bg-body-secondary rounded-4 h-100 to-best-buys-item d-flex align-items-center pe-3 py-4">
                        <div class="to-best-buys-img me-3">
                            <img src="{{ asset('public/storage/img/svg/solution.svg') }}" alt="" class="w-100">
                        </div>
                        <div class="info">
                            <h4 class="mb-1">Дизайн-решение</h4>
                            <span>Спроектируем ванную комнату в 3D</span>
                            <br>
                            <span class="badge text-bg-primary">Бесплатно!</span>
                        </div>
                        <div class="see ms-auto rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px">
                            <svg class="ms-1" height="65%" id="Layer_1" style="enable-background:new 0 0 512 512;"
                                version="1.1" viewBox="0 0 512 512" width="65%" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="bg-body-secondary rounded-4 h-100 to-best-buys-item d-flex align-items-center pe-3 py-4">
                        <div class="to-best-buys-img me-3">
                            <img src="{{ asset('public/storage/img/svg/cashback.svg') }}" alt="" class="w-100">
                        </div>
                        <div class="info">
                            <h4 class="mb-1">Рассрочка и кешбэк</h4>
                            <span>Покупайте сантехнику <br> и получайте бонусы</span>
                        </div>
                        <div class="see ms-auto rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px">
                            <svg class="ms-1" height="65%" id="Layer_1" style="enable-background:new 0 0 512 512;"
                                version="1.1" viewBox="0 0 512 512" width="65%" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="bg-body-secondary rounded-4 h-100 to-best-buys-item d-flex align-items-center pe-3 py-4">
                        <div class="to-best-buys-img me-3">
                            <img src="{{ asset('public/storage/img/svg/setup.svg') }}" alt="" class="w-100">
                        </div>
                        <div class="info">
                            <h4 class="mb-1">Установка</h4>
                            <span>Опытные мастера установят <br> сантехнику</span>
                        </div>
                        <div class="see ms-auto rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px">
                            <svg class="ms-1" height="65%" id="Layer_1" style="enable-background:new 0 0 512 512;"
                                version="1.1" viewBox="0 0 512 512" width="65%" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="bg-body-secondary rounded-4 h-100 to-best-buys-item d-flex align-items-center pe-3 py-4">
                        <div class="to-best-buys-img me-3">
                            <img src="{{ asset('public/storage/img/svg/stores.svg') }}" alt="" class="w-100">
                        </div>
                        <div class="info">
                            <h4 class="mb-1">Магазина</h4>
                            <span>Посмотрите на товары <br> вживую</span>
                        </div>
                        <div class="see ms-auto rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px">
                            <svg class="ms-1" height="65%" id="Layer_1" style="enable-background:new 0 0 512 512;"
                                version="1.1" viewBox="0 0 512 512" width="65%" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="bg-body-secondary rounded-4 h-100 to-best-buys-item d-flex align-items-center pe-3 py-4">
                        <div class="to-best-buys-img me-3">
                            <img src="{{ asset('public/storage/img/svg/fastDelivery.svg') }}" alt=""
                                class="w-100">
                        </div>
                        <div class="info">
                            <h4 class="mb-1">Ускоренная доставка</h4>
                            <span>Заказывайте товары с пометкой</span>
                            <br>
                            <span class="badge text-bg-success">Доставим за 1-2 дня</span>
                        </div>
                        <div class="see ms-auto rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px">
                            <svg class="ms-1" height="65%" id="Layer_1" style="enable-background:new 0 0 512 512;"
                                version="1.1" viewBox="0 0 512 512" width="65%" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 " />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
