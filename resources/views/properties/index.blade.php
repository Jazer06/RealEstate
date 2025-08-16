@extends('layouts.app')

@section('title', 'Объекты недвижимости')

@section('content')
    <h2 class="mb-4 mt-6">Наши объекты недвижимости</h2>

    <!-- Карточка с изображением слайдера под заголовком -->
    @if (request('slider_id'))
        @php
            $selectedSlider = $sliders->firstWhere('id', request('slider_id'));
        @endphp
        @if ($selectedSlider && $selectedSlider->image_path)
            <div class="property-slider-wrapper mb-4">
                <div class="property-slider-card">
                    <img src="{{ asset('storage/' . $selectedSlider->image_path) }}"
                         alt="{{ $selectedSlider->title }}"
                         class="property-slider-image">
                    <div class="property-slider-caption">{{ $selectedSlider->title }}</div>
                </div>
            </div>
        @endif
    @endif


    @include('components.filters', [
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
        'priceMin' => $priceMin,
        'priceMax' => $priceMax,
        'areaMin' => $areaMin,
        'areaMax' => $areaMax,
    ])

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
                                 src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/300x200' }}"
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
                                        <p class="card-text pt-2 m-0">
                                            <strong>От: {{ number_format($property->price, 0, ' ', ' ') }} ₽</strong><br>
                                        </p>
                                        <p class="m-0">
                                            @if($property->area)
                                                <strong>м²</strong> {{ number_format($property->area, 1, ',', ' ') }}
                                            @endif
                                        </p>
                                        <p class="m-0">
                                            <strong>Адрес:</strong> {{ $property->address ?? '' }}
                                        </p>
                                        <p class="card-description">
                                            {{ $property->description ?? '' }}
                                        </p>
                                    </div>
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

    <div class="pagination-container mt-4">
        @if ($properties->hasPages())
            {{ $properties->appends(request()->query())->links('pagination::bootstrap-5') }}
        @endif
    </div>
@endsection