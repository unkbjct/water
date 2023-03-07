@extends('layouts.main')

@section('main')
    <div class="container my-5">
        <section id="brands" class="mx-auto" style="max-width: 500px">
            <h2 class="mb-4">Бренды</h2>
            <div class="brand-list">
                @foreach ($brands as $brand)
                    <a
                        href="{{ route('catalog.search', [
                            'category' => 'santehnika',
                            'brands[]' => $brand->id,
                        ]) }}">
                        <div class="card mb-4">
                            <div class="card-body">{{ $brand->name }} </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
@endsection
