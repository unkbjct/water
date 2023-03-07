@extends('layouts.admin')

@section('title')
    Таблица Транзакций
@endsection

@section('admin.main')
    <div class="container mt-5">
        <form action="{{ route('admin.transactions') }}" method="get">
            <div class="row gy-4 mb-4">
                <div class="col-lg-2">
                    <div class="sort">
                        <label for="id" class="form-label">Номер</label>
                        <input type="text" value="{{ old('id') }}" name="id" id="id  "
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort">
                        <label for="status" class="form-label">Статус</label>
                        <select name="status" id="status" class="form-select form-select-sm">
                            <option value="">Любой</option>
                            <option @if (old('status') === 'CREATED') selected @endif value="CREATED">Ожидает оплаты
                            </option>
                            <option @if (old('status') === 'CANCELED') selected @endif value="CANCELED">Отменен</option>
                            <option @if (old('status') === 'FINISHED') selected @endif value="FINISHED">Выполнен</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sort h-100 d-flex flex-column">
                        <div class="btn-group mt-auto">
                            <a href="{{ Route('admin.transactions') }}" class="btn btn-secondary btn-sm">Сборсить</a>
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
                    <th scope="col">Сумма</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Создан</th>
                    <th scope="col">Обновлен</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <th scope="row">{{ $transaction->id }}</th>
                        <td>
                            @switch($transaction->status)
                                @case('CREATED')
                                    <span class="badge text-bg-secondary">Ожидает оплаты</span>
                                @break

                                @case('CANCELED')
                                    <span class="badge text-bg-danger">Отменен</span>
                                @break

                                @case('FINISHED')
                                    <span class="badge text-bg-success">Выполнен</span>
                                @break
                            @endswitch
                        </td>
                        <td><a href="{{ route('admin.users', ['id' => $transaction->user]) }}">{{ $transaction->user }}</a></td>
                        <td>{{ $transaction->price }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ $transaction->created_at }}</td>
                        <td>{{ $transaction->updated_at }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="fs-5 text-center py-5">По заданным фильтрам ничего не найдено</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endsection
