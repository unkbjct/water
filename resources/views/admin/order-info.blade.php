@extends('layouts.admin')

@section('title')
    Заказ № {{ $order->id }}
@endsection

@section('adds-component')
    <link rel="stylesheet" href="{{ asset('public/css/history.css') }}">
@endsection

@section('admin.main')
    <div class="container mt-5">
        <h3 class="mb-5">Заказ № {{ $order->id }} от {{ $order->created_at }}</h3>

        <div class="mb-5">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('success') }}
                </div>
            @endif

            <h5 class="mb-3">Основная информаци</h5>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="fs-5 me-auto">Общая стоимость:
                            {{ number_format($order->transaction->price, '0', '', ' ') }}
                            ₽.</div>
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
                    <form action="{{ route('core.admin.orders.change', ['order' => $order->id]) }}" class="edit-order" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Изменить статус заказа</label>
                            <div class="input-group">
                                <select class="form-select" name="status" id="status"
                                    aria-label="Example select with button addon">
                                    <option @if($order->status == 'PROCESSING') selected @endif value="PROCESSING">В процессе доставки</option>
                                    <option @if($order->status == 'CANCELED') selected @endif value="CANCELED">Отменен</option>
                                    <option @if($order->status == 'FINISHED') selected @endif value="FINISHED">Получен</option>
                                </select>
                                <button class="btn btn-success" type="submit">Сохранить</button>
                            </div>
                        </div>
                    </form>
                    <div class="text-end">
                        <small class="me-4">Создан: {{ $order->created_at }}</small>
                        <small>Обнавлен: {{ $order->updated_at }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h5 class="mb-3">Товары в заказе</h5>
            @foreach ($order->products as $product)
                <div class="card mb-4">
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
                                    <a href="{{ route('catalog.search', ['category' => $product->category->title_eng]) }}">Категория:
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
        </div>

        <div class="mb-5">
            <h5 class="mb-3">Информация о заказчике</h5>
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="mb-4">Данные пользователя</h5>
                            <div class="d-flex flex-wrap">
                                <div class="d-flex mb-2 me-5">
                                    <div class="me-3 fw-semibold">Имя:</div>
                                    <div><i>{{ $order->user->name }}</i></div>
                                </div>
                                <div class="d-flex mb-2 me-5">
                                    <div class="me-3 fw-semibold">Фамилия:</div>
                                    <div><i>{{ $order->user->surname }}</i></div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="me-3 fw-semibold">email:</div>
                                    <div><i>{{ $order->user->email }}</i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="mb-4">Данные указанные в заказе</h5>
                            <div class="d-flex flex-wrap">
                                <div class="d-flex mb-2 me-5">
                                    <div class="me-3 fw-semibold">Имя:</div>
                                    <div><i>{{ $order->name }}</i></div>
                                </div>
                                <div class="d-flex mb-2 me-5">
                                    <div class="me-3 fw-semibold">Фамилия:</div>
                                    <div><i>{{ $order->surname }}</i></div>
                                </div>
                                <div class="d-flex mb-2 me-5">
                                    <div class="me-3 fw-semibold">email:</div>
                                    <div><i>{{ $order->email }}</i></div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="me-3 fw-semibold">Телефон:</div>
                                    <div><i>{{ $order->phone }}</i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4">Адрес</h5>
                            <div class="d-flex flex-wrap">
                                <div class="d-flex mb-2 me-4">
                                    <div class="me-3 fw-semibold">Город:</div>
                                    <div><i>{{ $order->city }}</i></div>
                                </div>
                                <div class="d-flex mb-2 me-4">
                                    <div class="me-3 fw-semibold">Улица:</div>
                                    <div><i>{{ $order->street }}</i></div>
                                </div>
                                <div class="d-flex mb-2 me-4">
                                    <div class="me-3 fw-semibold">Дом:</div>
                                    <div><i>{{ $order->house }}</i></div>
                                </div>
                                <div class="d-flex mb-2 me-4">
                                    <div class="me-3 fw-semibold">Корпус:</div>
                                    <div><i>{{ $order->build ? $order->build : '-' }}</i></div>
                                </div>
                                <div class="d-flex mb-2 me-4">
                                    <div class="me-3 fw-semibold">Квартира:</div>
                                    <div><i>{{ $order->apart }}</i></div>
                                </div>
                                <div class="w-100"></div>
                                <div class="d-flex mb-2 me-4">
                                    <div class="me-3 fw-semibold">Комментарий:</div>
                                    <div><i>{{ $order->comment ? $order->comment : '-' }}</i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
