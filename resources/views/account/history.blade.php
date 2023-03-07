@extends('layouts.account')

@section('title')
    История заказов
@endsection

@section('adds-component')
    <link rel="stylesheet" href="{{ asset('public/css/history.css') }}">
@endsection

@section('account.main')
    <div class="container my-5">
        <h1 class="mb-5">История заказов</h1>
        @if ($orders->isEmpty())
            <p>Вы еще ничего не заказывали, выберите что-нибудь в <a href="">каталоге</a>.</p>
        @else
            @foreach ($orders as $order)
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="div">
                                <div class="fs-4 mb-2">Заказ № {{ $order->id }} от {{ $order->created_at }}</div>
                                @switch($order->status)
                                    @case('PROCESSING')
                                        <span class="badge text-bg-primary">В процессе доставки</span>
                                    @break

                                    @case('CANCELED')
                                        <span class="badge text-bg-danger">отменен</span>
                                    @break

                                    @case('FINISHED')
                                        <span class="badge text-bg-success">Получен</span>
                                    @break
                                    
                                    @case('CREATED')
                                        <span class="badge text-bg-secondary">Ожидает подтверждения</span>
                                    @break
                                @endswitch
                            </div>
                            <div class="div ms-auto">
                                <div class="fs-4">{{ number_format($order->fullPrice, '0', '', ' ') }} ₽.</div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex align-items-center">
                            <div>{{ "{$order->city}, {$order->street} Д. {$order->house} кв. {$order->apart}" }}</div>
                            {{-- <div class="vr mx-4"></div> --}}
                            {{-- <div>{{ "{$order->fullCount}" }}</div> --}}
                            <div class="ms-auto">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="collapse"
                                    data-bs-target="#product-list-{{ $order->id }}">Подробнее</button>
                            </div>
                        </div>
                        <div class="collapse" id="product-list-{{ $order->id }}">
                            <div class="mt-4">
                                @foreach ($order->products as $product)
                                    <div class="history-item">
                                        <div class="card-body d-flex">
                                            <a href="{{ route('product', ['product' => $product->id]) }}">
                                                <div class="history-img">
                                                    <img class="h-100" src="{{ asset($product->image) }}" alt="">
                                                </div>
                                            </a>
                                            <div class="d-flex flex-column w-100">
                                                <div class="d-flex align-items-center mb-4">
                                                    <a href="{{ route('product', ['product' => $product->id]) }}">
                                                        <div class="history-title fs-5">{{ $product->title }}</div>
                                                    </a>
                                                    <div class="vr mx-3"></div>
                                                    <div class="fs-5">
                                                        {{ number_format($product->price - $product->price * ($product->sale / 100), 0, ',', ' ') }}
                                                        ₽. / шт.</div>
                                                    <div class="fs-5 ms-auto">
                                                        {{ number_format(($product->price - $product->price * ($product->sale / 100)) * $product->count, 0, ',', ' ') }}
                                                        ₽.
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="d-flex mb-2">
                                                        <a href="" class="me-5">Бренд: {{ $product->brand }}</a>
                                                        <a
                                                            href="{{ route('catalog.search', ['category' => $product->category->title_eng]) }}">Категория:
                                                            {{ $product->category->title }}</a>
                                                    </div>
                                                    <div class="mb-2">Количество: {{ $product->count }} шт.</div>
                                                    @if ($product->sale)
                                                        <div class="mb-2">Скидка: {{ $product->sale }} %</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($order->comment)
                                    <div class="mt-4">
                                        <p><span class="fw-semibold">Ваш комментарий к заказу</span>: {{ $order->comment }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        {{-- <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Товар</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Дата</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td><a href="">Гигиенический душ STWORKI by</a></td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Thornton</td>
                    <td>Larry the Bird</td>
                    <td>@twitter</td>
                </tr>
            </tbody>
        </table> --}}
    </div>
@endsection
