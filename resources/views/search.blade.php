@extends('layouts.main')

@section('title')
    Поиск - {{ $thisCategory->title }}
@endsection

{{-- <?dd()?> --}}

@section('adds-component')
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
    <script src="{{ asset('public/js/filter.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/css/filter.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('public/css/swiper.min.css') }}"> --}}
@endsection

@section('main')
    <div class="custom-fade">
    </div>
    <div class="container mb-5">
        <section class="mt-4">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                    @foreach ($categoryList as $categoryItem)
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('catalog.search', ['category' => $categoryItem->title_eng]) }}">{{ $categoryItem->title }}</a>
                        </li>
                    @endforeach
                </ol>
            </nav>
            <div class="d-flex align-items-end">
                <h2 class="my-0 me-3 lh-1">Поиск</h2>
                <span class="text-secondary" style="font-size: 12px">{{ $products->count() }} товаров</span>
            </div>
        </section>
        <section id="search" class="mt-4">
            <div class="row">
                <div class="col-sm-3 filter-col">
                    <div class="filter-header  pt-2 mb-4">
                        <div class="d-flex justify-content-between">
                            <h3>Фильтры</h3><button type="button" class="btn-hide-filters btn-close"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="filter-side">
                        <div class="categoies-tree mb-4">
                            {{-- @each('components.catalogCategory', $categoryTree, 'category') --}}
                            @foreach ($categoryTree as $category)
                                @include('components.catalogCategory')
                            @endforeach
                        </div>
                        <form action="{{ route('catalog.search', ['category' => $thisCategory->title_eng]) }}"
                            method="GET">
                            <div class="sort mb-3">
                                <label class="form-label" for="sort">Сортировать</label>
                                <select class="form-select" name="sort" id="sort"
                                    aria-label="Default select example">
                                    <option value="">По популярности</option>
                                    <option @if (old('sort') === 'price:asc') selected @endif value="price:asc">Сначала
                                        дешевые</option>
                                    <option @if (old('sort') === 'price:desc') selected @endif value="price:desc">Сначала
                                        дорогие</option>
                                </select>
                            </div>
                            <div class="sort mb-3">
                                <label class="form-label" for="title">Название</label>
                                <input class="form-control" value="{{old('title')}}" name="title" id="title"/>
                            </div>
                            <div class="form-check form-switch d-flex align-items-center justify-content-between p-0">
                                <label class="form-check-label" for="isHave">В наличии</label>
                                <input class="form-check-input" @if (old('isHave')) checked @endif
                                    type="checkbox" name="isHave" id="isHave">
                            </div>
                            <div class="form-check form-switch d-flex align-items-center justify-content-between p-0">
                                <label class="form-check-label" for="isSale">Со скидкой</label>
                                <input class="form-check-input" @if (old('isSale')) checked @endif
                                    type="checkbox" name="isSale" id="isSale">
                            </div>
                            <div class="mb-4">
                                <label class="mb-2">Цена</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">От</span>
                                    <input type="number" min="0" value="{{ old('price-from') }}" name="price-from"
                                        class="form-control">
                                    <span class="input-group-text">До</span>
                                    <input type="number" min="0" value="{{ old('price-to') }}" name="price-to"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="accordion mb-4" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseOne">
                                            Бренды
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            @foreach ($brands as $brand)
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        @if (old('brands')) @if (in_array($brand->id, old('brands'))) checked @endif
                                                        @endif type="checkbox" name="brands[]"
                                                    value="{{ $brand->id }}"
                                                    id="brand-{{ $brand->name }}">
                                                    <label class="form-check-label" for="brand-{{ $brand->name }}">
                                                        {{ $brand->name }}
                                                    </label>
                                                    <small>({{ $products->where('brand', $brand->id)->count() }})</small>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- @foreach ($attributes as $attr)
                                <div class="accordion mb-4">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#attr-{{ $attr->id }}">
                                                {{ $attr->name }}
                                            </button>
                                        </h2>
                                        <div id="attr-{{ $attr->id }}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                @foreach ($attr->values as $value)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="attributes[{{$value->id}}]"
                                                            value="{{ $value->value }}" id="value-{{ $value->id }}">
                                                        <label class="form-check-label" for="value-{{ $value->id }}">
                                                            {{ $value->value }}
                                                        </label>
                                                        <small>({{ $products->where('brand', $brand->id)->count() }})</small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach --}}

                            <div class="btn-group mb-4 w-100">
                                <a href="{{ route('catalog.search', ['category' => $thisCategory->title_eng]) }}"
                                    class="btn btn-secondary">Сбросить</a>
                                <button class="btn btn-warning">Применить</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-9 products-col">
                    <div class="">
                        <div class="setting-view d-flex justify-content-between">
                            <button class="btn-show-filters btn btn-sm btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-filter-left" viewBox="0 0 16 16">
                                    <path
                                        d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </button>
                        </div>
                        <div class="d-flex flex-wrap">

                            @if ($products->isNotEmpty())
                                @foreach ($products as $prod)
                                    <div class="product-item">
                                        <div style="height: 300px; overflow: hidden"
                                            class="d-flex justify-content-center rounded">
                                            <img class="h-100 w-100 mx-auto preview"
                                                src="{{ asset($prod->images[0]->url) }}" alt="">
                                        </div>
                                        <div class="price d-flex my-3">
                                            @if ($prod->sale)
                                                <div class="fresh-price">
                                                    <span
                                                        class="fresh-current-price">{{ number_format($prod->price - $prod->price * ($prod->sale / 100), 0, ',', ' ') }}</span>
                                                    ₽.
                                                </div>
                                                <div class="old-price"><span
                                                        class="old-current-price">{{ number_format($prod->price, 0, ',', ' ') }}</span>
                                                    ₽.
                                                </div>
                                                <span class="badge text-bg-danger ms-auto">-{{ $prod->sale }}%</span>
                                            @else
                                                <div class="fresh-price">
                                                    <span
                                                        class="fresh-current-price">{{ number_format($prod->price, 0, ',', ' ') }}</span>
                                                    ₽.
                                                </div>
                                            @endif
                                        </div>
                                        <div class="title">{{ $prod->title }}</div>
                                        <div class="rating d-flex">
                                            <div class="me-3">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="fa fa-star @if ($i <= $prod->rating) checked @endif"></span>
                                                @endfor
                                            </div>
                                            <span>
                                                @if ($prod->rating)
                                                    @switch(substr($prod->rating_count, -1))
                                                        @case(1)
                                                            {{ $prod->rating_count }} отзыв
                                                        @break

                                                        @case((int)(substr($prod->rating_count, -1)) <= 4)
                                                            {{ $prod->rating_count }} отзыва
                                                        @break

                                                        @default
                                                            {{ $prod->rating_count }} отзывов
                                                    @endswitch
                                                @else
                                                    нет отзывов
                                                @endif
                                            </span>
                                        </div>
                                        <div class="btns">
                                            <a href="{{ route('product', ['product' => $prod->id]) }}"
                                                class="btn btn-warning me-2 btn-sm w-100">Подробнее</a>
                                            <div class="add-to-favorites @if (isset($_COOKIE['favorites']) && in_array($prod->id, explode(',', $_COOKIE['favorites']))) activeFavorite @endif"
                                                data-product="{{ $prod }}">
                                                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M462.1 62.86C438.8 41.92 408.9 31.1 378.7 32c-37.49 0-75.33 15.4-103 43.98l-19.7 20.27l-19.7-20.27C208.6 47.4 170.8 32 133.3 32C103.1 32 73.23 41.93 49.04 62.86c-62.14 53.79-65.25 149.7-9.23 207.6l193.2 199.7C239.4 476.7 247.6 480 255.9 480c8.332 0 16.69-3.267 23.01-9.804l193.1-199.7C528.2 212.5 525.1 116.6 462.1 62.86zM437.6 237.1l-181.6 187.8L74.34 237.1C42.1 203.8 34.46 138.1 80.46 99.15c39.9-34.54 94.59-17.5 121.4 10.17l54.17 55.92l54.16-55.92c26.42-27.27 81.26-44.89 121.4-10.17C477.1 138.6 470.5 203.1 437.6 237.1z" />
                                                    <path fill="#fff" class="filledFavorite"
                                                        d="M429.9,95.6c-40.4-42.1-106-42.1-146.4,0L256,124.1l-27.5-28.6c-40.5-42.1-106-42.1-146.4,0c-45.5,47.3-45.5,124.1,0,171.4   L256,448l173.9-181C475.4,219.7,475.4,142.9,429.9,95.6z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted mt-5 mx-auto">
                                    <h2>Товыра не найдены</h2>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
