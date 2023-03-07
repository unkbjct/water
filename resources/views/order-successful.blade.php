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
            <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#0d6efd" class="bi bi-check-square-fill my-5" viewBox="0 0 16 16">
                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                </svg>
                <div class="my-5">
                    <div class="display-5">Спасибо за покупку!</div>
                    <p class="fw-semibold">Ваш заказ № {{$order->id}} успешно создан</p>    
                </div>
                <a href="{{route('account.history')}}" class="btn btn-warning">Посмотреть в личном кабинете</a>
            </div>
            {{-- {{$order->id}} --}}
        </section>
    </div>
@endsection
