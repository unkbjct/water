@extends('layouts.main')

@section('title')
    {{ config('app.name') }}
@endsection

@section('adds-component')
    <script src="{{ asset('public/js/swiper-element-bundle.min.js') }}"></script>
    <script src="{{ asset('public/js/product.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/css/product.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('public/css/swiper.min.css') }}"> --}}
@endsection

@section('main')
    <div class="container pt-4">
        @if (session()->has('success'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="tree">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                    @foreach ($categoryList as $categoryItem)
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('catalog.search', ['category' => $categoryItem->title_eng]) }}">{{ $categoryItem->title }}</a>
                        </li>
                    @endforeach
                    <li class="breadcrumb-item active" aria-current="page"><a href="">{{ $product->title }}</a></li>
                </ol>
            </nav>
        </div>
        <div class="content">
            <div class="d-flex justify-content-between">
                <h1 class="h3 mb-4">{{ $product->title }}</h1>
                <p id="product-id" data-id="{{ $product->id }}">Артикул: {{ $product->id }}</p>
            </div>
            <div class="row gy-4 mb-5">
                <div class="col-sm-8">
                    <div class="product-prev">
                        <swiper-container thumbs-swiper=".mySwiper2" space-between="10" class="main-swiper"
                            navigation="false">
                            @foreach ($product->images as $img)
                                <swiper-slide>
                                    <img src="{{ asset($img->url) }}" />
                                </swiper-slide>
                            @endforeach
                        </swiper-container>
                        <swiper-container class="mySwiper2" space-between="10" direction="vertical"
                            slides-per-view="{{ $product->images->count() }}" free-mode="true"
                            watch-slides-progress="true">
                            @foreach ($product->images as $img)
                                <swiper-slide>
                                    <img src="{{ asset($img->url) }}" />
                                </swiper-slide>
                            @endforeach
                        </swiper-container>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="">
                        <div class="shadow-sm p-3 rounded mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="price d-flex">
                                    @if ($product->sale)
                                        <div class="fresh-price">
                                            <span
                                                class="fresh-current-price">{{ number_format($product->price - $product->price * ($product->sale / 100), 0, ',', ' ') }}</span>
                                            ₽.
                                        </div>
                                        <div class="old-price"><span
                                                class="old-current-price">{{ number_format($product->price, 0, ',', ' ') }}</span>
                                            ₽.
                                        </div>
                                        <span class="badge text-bg-danger">-{{ $product->sale }}%</span>
                                    @else
                                        <div class="fresh-price">
                                            <span
                                                class="fresh-current-price">{{ number_format($product->price, 0, ',', ' ') }}</span>
                                            ₽.
                                        </div>
                                    @endif
                                </div>
                                <div class="add-to-favorites @if (isset($_COOKIE['favorites']) && in_array($product->id, explode(',', $_COOKIE['favorites']))) activeFavorite @endif"
                                    data-product="{{ $product }}">
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M462.1 62.86C438.8 41.92 408.9 31.1 378.7 32c-37.49 0-75.33 15.4-103 43.98l-19.7 20.27l-19.7-20.27C208.6 47.4 170.8 32 133.3 32C103.1 32 73.23 41.93 49.04 62.86c-62.14 53.79-65.25 149.7-9.23 207.6l193.2 199.7C239.4 476.7 247.6 480 255.9 480c8.332 0 16.69-3.267 23.01-9.804l193.1-199.7C528.2 212.5 525.1 116.6 462.1 62.86zM437.6 237.1l-181.6 187.8L74.34 237.1C42.1 203.8 34.46 138.1 80.46 99.15c39.9-34.54 94.59-17.5 121.4 10.17l54.17 55.92l54.16-55.92c26.42-27.27 81.26-44.89 121.4-10.17C477.1 138.6 470.5 203.1 437.6 237.1z" />
                                        <path fill="#fff" class="filledFavorite"
                                            d="M429.9,95.6c-40.4-42.1-106-42.1-146.4,0L256,124.1l-27.5-28.6c-40.5-42.1-106-42.1-146.4,0c-45.5,47.3-45.5,124.1,0,171.4   L256,448l173.9-181C475.4,219.7,475.4,142.9,429.9,95.6z" />
                                    </svg>
                                </div>
                            </div>
                            <form action="{{ route('product.cart.add', ['product' => $product->id]) }}" method="POST">
                                @csrf
                                <button href="" class="btn btn-warning w-100 mt-2">Добавить в корзину</button>
                            </form>
                        </div>
                        <div class="shadow-sm p-3 rounded mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <p><b>Получение в г. Великий Новгород</b></p>
                                <p><span class="badge text-bg-success">В наличии</span></p>
                            </div>
                            <div>
                                <p>Доставка: от 590 ₽</p>
                                {{-- <p><a class="text-decoration-none" href="">Пункт выдачи</a>: Завтра, Бесплатно --}}
                                </p>
                                <hr>
                                <p>Установка: 2 000 ₽</p>
                            </div>
                        </div>
                        <div>
                            <p><b>О товаре</b></p>
                            <div class="about-item">
                                <div class="about-title">Бренд</div>
                                <div class="about-value"><a
                                        href="{{ route('catalog.search', [
                                            'category' => 'santehnika',
                                            'brands[]' => $product->brand->id,
                                        ]) }}">{{ $product->brand->name }}</a>
                                </div>
                            </div>
                            <div class="about-item">
                                <div class="about-title">Артикул</div>
                                <div class="about-value">{{ $product->article }}</div>
                            </div>
                            <div class="about-item">
                                <div class="about-title">{{ $product->attributes[0]->name }}</div>
                                <div class="about-value">{{ $product->attributes[0]->value }}</div>
                            </div>
                            <a href="#aboutProduct" class="text-decoration-none">Описание товара</a>
                        </div>
                    </div>
                </div>
            </div>

            @if ($brandList->isNotEmpty())
                <div class="suggestins-brand mb-5">
                    <h2 class="mb-4">Вас заинтересует в бренде Olive'S</h2>
                    <swiper-container class="swiper-suggestions-brand" init="false" navigation="true">
                        @foreach ($brandList as $brandList)
                            <swiper-slide>
                                <div class="suggestions-item shadow text-start bg-body-tertiary text-center px-3 py-2"
                                    style="height: 300px">
                                    <img src="{{ asset($brandList->image->url) }}" alt=""
                                        class="mx-auto rounded w-100" style="height: 60%; object-fit: contain;">
                                    <p class="suggestions-price">{{ $brandList->price }} ₽</p>
                                    <a href="{{ route('product', ['product' => $brandList->id]) }}">
                                        <p class="suggestions-title">{{ $brandList->title }}</p>
                                    </a>
                                </div>
                            </swiper-slide>
                        @endforeach
                    </swiper-container>
                </div>
            @endif

            <div class="product-information mb-5" id="aboutProduct">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#about"
                            type="button" role="tab" aria-controls="about" aria-selected="true">О товаре</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-pane" type="button" role="tab"
                            aria-controls="profile-tab-pane" aria-selected="false">Характеристики</button>
                    </li>
                </ul>
                <div class="tab-content mt-4" id="myTabContent">
                    <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab"
                        tabindex="0">
                        <div class="row gy-4">
                            <div class="col-sm-8">
                                <p class="description">{{ $product->description }}</p>
                                <ul class="small-attributes">
                                    @for ($i = 0; $i < $product->attributes->count(); $i++)
                                        <li>
                                            {{ $product->attributes[$i]->name }}: {{ $product->attributes[$i]->value }}
                                        </li>
                                        @if ($i + 1 == 2)
                                        @break
                                    @endif
                                @endfor
                            </ul>
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3">
                            <div class="border rounded shadow-sm p-4">
                                <p><b>Что в поставке?</b></p>
                                <ul class="what-in-box">
                                    @foreach ($product->inclusions as $inclusion)
                                        <li>{{ $inclusion->value }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        @foreach ($product->attributes as $attr)
                            <div class="col-lg-6">
                                <div class="about-item">
                                    <div class="about-title">{{ $attr->name }}</div>
                                    <div class="about-value"><i>{{ $attr->value }}</i></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <div class="reviews mb-5">
            <h2 class="mb-4">Отзывы</h2>
            <div class="row gy-4">
                <div class="col-sm-9">
                    <div class="review-list">
                        @forelse($reviews as $review)
                            <div class="review-item">
                                <div class="review-user-photo">
                                    <svg fill="#0d6efd" width="100%" height="" viewBox="0 0 32 32"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <title />
                                        <g data-name="user people person users man" id="user_people_person_users_man">
                                            <path
                                                d="M23.74,16.18a1,1,0,1,0-1.41,1.42A9,9,0,0,1,25,24c0,1.22-3.51,3-9,3s-9-1.78-9-3a9,9,0,0,1,2.63-6.37,1,1,0,0,0,0-1.41,1,1,0,0,0-1.41,0A10.92,10.92,0,0,0,5,24c0,3.25,5.67,5,11,5s11-1.75,11-5A10.94,10.94,0,0,0,23.74,16.18Z" />
                                            <path
                                                d="M16,17a7,7,0,1,0-7-7A7,7,0,0,0,16,17ZM16,5a5,5,0,1,1-5,5A5,5,0,0,1,16,5Z" />
                                        </g>
                                    </svg>
                                </div>
                                <div class="review-information">
                                    <div class="d-flex">
                                        <p><b>{{ $review->name }}</b></p>
                                        <div class="fs-6 ms-3 text-muted">{{ $review->created_at }}</div>
                                    </div>
                                    <p>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="fa fa-star @if ($i <= $review->rating) checked @endif"></span>
                                        @endfor
                                    </p>
                                    <p class="review-advantages">
                                        <b>Достоинства</b>
                                    <div>{{ $review->advantages }}</div>
                                    </p>
                                    <p class="review-advantages">
                                        <b>Недостатки</b>
                                    <div>{{ $review->flaw }}</div>
                                    </p>
                                    <p class="review-advantages">
                                        <b>Комментарии</b>
                                    <div>{{ $review->comment }}</div>
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted fs-3 text-center my-5 py-5">Нет отзывов</div>
                        @endforelse

                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="total-reviews">
                        <p class="total-reviews-title">{{ $product->rating }}</p>
                        <p class="scaled-fa-star">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="fa fa-star @if ($i <= $product->rating) checked @endif"></span>
                            @endfor
                        </p>
                        <p>На основе {{ $reviews->count() }} оценок</p>
                        {{-- <div class="star-item d-flex align-items-center">
                            <span class="me-2">5</span>
                            <span class="fa fa-star checked me-2"></span>
                            <div class="progress w-100">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="star-item d-flex align-items-center">
                            <span class="me-2">4</span>
                            <span class="fa fa-star checked me-2"></span>
                            <div class="progress w-100">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                        </div>
                        <div class="star-item d-flex align-items-center">
                            <span class="me-2">3</span>
                            <span class="fa fa-star checked me-2"></span>
                            <div class="progress w-100">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="star-item d-flex align-items-center">
                            <span class="me-2">2</span>
                            <span class="fa fa-star checked me-2"></span>
                            <div class="progress w-100">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                        </div>
                        <div class="star-item d-flex align-items-center">
                            <span class="me-2">1</span>
                            <span class="fa fa-star checked me-2"></span>
                            <div class="progress w-100">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                        </div> --}}
                        <button class="btn btn-warning w-100 mt-4" data-bs-toggle="modal"
                            data-bs-target="#createReviewModal">Оставить отзыв</button>
                    </div>
                    <div class="mt-4">
                        <p>Замечания и предложения по работе магазина вы можете написать в разделе <a class="link"
                                href="">Обратная связь</a></p>
                    </div>
                </div>
            </div>
        </div>
        @if ($watchedList->isNotEmpty())
            <div class="watched mb-5">
                <h2 class="mb-4">Вы интерисовались</h2>
                <swiper-container class="swiper-watched" init="false" navigation="true">
                    @foreach ($watchedList as $watchedItem)
                        <swiper-slide>
                            <div class="suggestions-item shadow text-start bg-body-tertiary text-center px-3 py-2"
                                style="height: 300px">
                                <img src="{{ asset($watchedItem->image->url) }}" alt=""
                                    class="mx-auto rounded w-100" style="height: 60%; object-fit: contain;">
                                <p class="suggestions-price">{{ $watchedItem->price }} ₽</p>
                                <a href="{{ route('product', ['product' => $watchedItem->id]) }}">
                                    <p class="suggestions-title">{{ $watchedItem->title }}</p>
                                </a>
                            </div>
                        </swiper-slide>
                    @endforeach
                </swiper-container>
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="createReviewModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Оставьте отзыв о данном товаре</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5">
                <form id="form-review" action="{{ route('product.review.create', ['product' => $product->id]) }}"
                    method="POST">
                    @csrf
                    <div class="mb-4">
                        <h3>{{ $product->title }}</h3>
                        <span class="me-4">{{ $product->category->title }}</span>
                        <span>{{ $product->brand }}</span>
                    </div>
                    <input type="hidden" required name="raiting" id="raiting">
                    <div class="mb-3 d-flex align-items-center">
                        <label for="advantages" class="form-label fw-semibold fs-4 me-3">Оценка:</label>
                        <p class="scaled-fa-star review-stars mb-2 d-flex rounded need-validation" id="review-stars">
                            <span id="review-star-1" data-score="1" class="fa px-1 review-star fa-star"></span>
                            <span id="review-star-2" data-score="2" class="fa px-1 review-star fa-star"></span>
                            <span id="review-star-3" data-score="3" class="fa px-1 review-star fa-star"></span>
                            <span id="review-star-4" data-score="4" class="fa px-1 review-star fa-star"></span>
                            <span id="review-star-5" data-score="5" class="fa px-1 review-star fa-star"></span>
                        </p>
                    </div>
                    <div class="mb-4">
                        <label for="advantages" class="form-label fw-semibold">Достоинства</label>
                        <textarea required class="form-control need-validation" name="advantages" id="advantages"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="flaw" class="form-label fw-semibold">Недостатки</label>
                        <textarea required class="form-control need-validation" name="flaw" id="flaw"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="form-label fw-semibold">Комментарий</label>
                        <textarea required class="form-control need-validation" name="comment" id="comment"></textarea>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-secondary ms-auto" data-bs-toggle="modal"
                            data-bs-dismiss="true">Отмена</button>
                        <button type="button" id="btn-create-review" class="btn btn-primary ms-4">Оставить
                            отзыв</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
