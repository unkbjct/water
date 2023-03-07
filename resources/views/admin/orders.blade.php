@extends('layouts.admin')


@section('admin.main')
    <section class="container my-5">
        <form action="{{ route('admin.orders') }}" method="get">
            <div class="row gy-4 mb-4">
                <div class="col-lg-2">
                    <div class="sort">
                        <label for="orders_id" class="form-label">Номер</label>
                        <input type="text" value="{{ old('orders_id') }}" name="orders_id" id="orders_id  "
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort">
                        <label for="orders_status" class="form-label">Статус</label>
                        <select name="orders_status" id="orders_status" class="form-select form-select-sm">
                            <option value="">Любой</option>
                            <option @if (old('orders_status') === 'PROCESSING') selected @endif value="PROCESSING">В процессе доставки
                            </option>
                            <option @if (old('orders_status') === 'CANCELED') selected @endif value="CANCELED">Отменен</option>
                            <option @if (old('orders_status') === 'FINISHED') selected @endif value="FINISHED">Получен</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort h-100 d-flex flex-column">
                        <div class="btn-group mt-auto">
                            <a href="{{ Route('admin.orders') }}" class="btn btn-secondary btn-sm">Сборсить</a>
                            <button type="submit" class="btn btn-success btn-sm">Применить</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5"></div>
            </div>
        </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Пользователь</th>
                    <th scope="col">Цена ₽.</th>
                    <th scope="col">Транзакция</th>
                    <th scope="col">Дата добавления</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>
                            @switch($order->status)
                                @case('PROCESSING')
                                    <span class="badge text-bg-primary">В процессе доставки</span>
                                @break

                                @case('CANCELED')
                                    <span class="badge text-bg-danger">Отменен</span>
                                @break

                                @case('FINISHED')
                                    <span class="badge text-bg-success">Получен</span>
                                @break

                                @case('CREATED')
                                    <span class="badge text-bg-secondary">Ожидает подтверждения</span>
                                @break
                            @endswitch
                        </td>
                        <td><a href="{{ route('admin.users', ['id' => $order->user]) }}">{{ $order->user }}</a></td>
                        <td>{{ number_format($order->price, '0', '', ' ') }}</td>
                        <td><a href="{{ route('admin.transactions', ['id' => $order->transaction]) }}">{{ $order->transaction }}</a></td>
                        <td>{{ $order->created_at }}</td>
                        <td class="d-flex"><a href="{{ route('admin.orders.info', ['order' => $order->id]) }}"
                                class="btn btn-warning btn-sm ms-auto">Подробнее</a></td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="fs-5 text-center py-5">По заданным фильтрам ничего не найдено</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    @endsection
