@extends('layouts.main')

@section ('title') {{config('Каталог')}} @endsection


@section('adds-component')
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>
    <script src="{{ asset('public/js/welcome.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/css/welcome.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('public/css/swiper.min.css') }}"> --}}
@endsection

@section('main')
    <div class="container">
    </div>
@endsection
