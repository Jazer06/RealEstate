@extends('layouts.app')

@section('title', 'Объекты недвижимости')

@if ($selectedSlider = $sliders->firstWhere('id', request('slider_id')))
    @section('carousel')
        <div class="castom full-screen-carousel">
            <div class="carousel-inner">
                {{-- Основное изображение --}}
                @if ($selectedSlider->image_path)
                    <div class="carousel-slide">
                        <img src="{{ asset('storage/' . $selectedSlider->image_path) }}"
                             alt="{{ $selectedSlider->title }}">
                        <div class="container">
                            <div class="slide-content mt-40">
                                <h1 class="slide-title text-white shadow-[0_4px_4px_rgba(0,0,0,0.25)]">{{ $selectedSlider->title }}</h1>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Дополнительные изображения --}}
                @foreach ($selectedSlider->images as $image)
                    <div class="carousel-slide">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             alt="{{ $selectedSlider->title }} - Additional">
                        <div class="container">
                            <div class="slide-content mt-40">
                                <h1 class="slide-title text-white shadow-[0_4px_4px_rgba(0,0,0,0.25)]">{{ $selectedSlider->title }}</h1>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Если нет изображений --}}
                @if (!$selectedSlider->image_path && $selectedSlider->images->isEmpty())
                    <div class="alert alert-warning">Нет изображений для этого ЖК</div>
                @endif
            </div>
        </div>

        <div class="container" >
            <div class="" style="background-color: #413f3f99; backdrop-filter: blur(2px); margin: -6rem 1rem;">
                <button class="carousel-nav-btn up">←</button>
                <button class="carousel-nav-btn down">→</button>
            </div>

            <div class="row" style="display: none;">
                <div class="custom-thumbs-container" style="top: -185px;">
                    @if ($selectedSlider->image_path)
                        <div class="thumb-item active" data-slide-index="0">
                            <div class="thumb-content">
                                <div class="row">
                                    <div class="col-6">
                                        <img src="{{ asset('storage/' . $selectedSlider->image_path) }}"
                                             alt="{{ $selectedSlider->title }}" class="castom-thumb-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @foreach ($selectedSlider->images as $index => $image)
                        <div class="thumb-item" data-slide-index="{{ $index + 1 }}">
                            <div class="thumb-content">
                                <div class="row">
                                    <div class="col-6">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="{{ $selectedSlider->title }}" class="castom-thumb-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($selectedSlider)
            <div class="row mt-6">
                    <div class="col-md-6 mb-4">
                        <h3>{{ $selectedSlider->title }}</h2>
                    </div>
                <div class="col-md-6">
                    <div class="slider-description">
                    @if ($selectedSlider->description)
                        <p>{{ $selectedSlider->description }}</p>
                    @else
                        <p>Описание отсутствует</p>
                        
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <style>
            .castom-thumb-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>
    @endsection
@endif

@section('content')

    @if (!$selectedSlider)
        <h2 class="mb-4 mt-54">Наши объекты недвижимости</h2>
    @endif

    @if (session('success'))
        <div class="alert alert-success mb-4 text-center floating-alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ФИЛЬТРЫ --}}
    @include('components.filters', [
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
        'priceMin' => $priceMin,
        'priceMax' => $priceMax,
        'areaMin' => $areaMin,
        'areaMax' => $areaMax,
    ])

    {{-- СПИСОК ОБЪЕКТОВ --}}
    @if($totalProperties === 0)
        <div class="alert alert-warning mt-4 glass-effect-banner">
            По вашему запросу ничего не найдено.
        </div>
    @else
        <div class="row mt-6">
            @forelse ($properties as $property)
                <div class="col-xl-4 col-sm-12 mb-4">
                    <div class="card property-card h-100" onclick="window.location='{{ route('properties.show', $property->id) }}'">
                        <div class="card-img-container">
                            <img class="primary-img"
                                 src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/300x200  ' }}"
                                 alt="{{ $property->title }}">

                            @if ($property->images()->where('is_plan', true)->first())
                                <img class="secondary-img"
                                     src="{{ asset('storage/' . $property->images()->where('is_plan', true)->first()->image_path) }}"
                                     alt="{{ $property->title }} - план дома">
                            @endif

                            <div class="card-footer-button"
                                 style="position: absolute; top: 12px; right: 12px; padding: 15px; z-index: 10;"
                                 onclick="event.stopPropagation();">
                                @auth
                                    <form action="{{ route('favorites.toggle', $property->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="favorite-icons {{ auth()->user()->favorites->contains($property->id) ? 'favorite-added' : '' }}"
                                                title="{{ auth()->user()->favorites->contains($property->id) ? 'Убрать из избранного' : 'Добавить в избранное' }}"
                                                style="border: none; background: none; cursor: pointer;">
                                            <i class="bi bi-heart"></i>
                                            @if (auth()->user()->favorites->contains($property->id))
                                                <i class="bi bi-x-lg"></i>
                                            @endif
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="favorite-icon text-muted"
                                       title="Войдите, чтобы добавить в избранное"
                                       style="display: inline-block;">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="card-body-content flex-grow-1">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h5 class="card-title fst-italic pt-2">{{ $property->title }}</h5>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-0" style="padding-top: 10px;">
                                            @if($property->area)
                                                <strong>м²</strong> {{ number_format($property->area, 1, ',', ' ') }}
                                            @endif
                                        </p>
                                        @if(!empty($property->address) && $property->address !== 'Адрес не указан')
                                        <p class="m-0" style="padding-top: 10px;">
                                                <strong>Адрес:</strong> {{ $property->address }}
                                        </p>
                                        @endif
                                        <p class="card-text mb-2" style="padding-top:10px">
                                            @if($property->price > 0)
                                                <strong> Цена:{{ number_format($property->price, 0, ' ', ' ') }} ₽</strong>
                                            @else
                                                <strong>Цена: <a href="{{ route('consultation') }}" class="btn btn-outline-secondary">Узнать цену</a></strong>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <p class="card-description p-2">
                                        {{ $property->description ?? '' }}
                                    </p>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">Объекты пока не добавлены.</p>
                </div>
            @endforelse
        </div>
    @endif

    {{-- ПАГИНАЦИЯ --}}
    <div class="pagination-container mt-4">
        @if ($properties->hasPages())
            {{ $properties->appends(request()->query())->links('pagination::bootstrap-5') }}
        @endif
    </div>
@endsection