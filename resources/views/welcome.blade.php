@extends('layouts.app')

@section('carousel')
<div class="full-screen-carousel">
    <div class="carousel-inner">


        @foreach ($sliders as $slider)
            <div class="carousel-slide">
                <img src="{{ $slider->image_path ? asset('storage/' . $slider->image_path) : 'https://via.placeholder.com/1200x800' }}" alt="{{ $slider->title }}">
                <div class="container">
                    <div class="slide-content mt-25">
                        <h1 class="slide-title">{{ $slider->title }}</h1>
                        <p class="slide-subtitle">{{ $slider->subtitle }}</p>
                        <a href="{{ $slider->button_link }}" class="iphone-button">{{ $slider->button_text }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="container">
        <div class="carousel-nav-buttons d-sm-block d-none">
            <button class="carousel-nav-btn down">←</button>
            <button class="carousel-nav-btn up">→</button>
        </div>
    <div class="row">
        <div class="custom-thumbs-container">
            @foreach ($sliders as $index => $slider)
                <div class="thumb-item @if ($loop->first) active @endif" data-slide-index="{{ $index }}">
                    <div class="thumb-content">
                        <div class="row">
                            <div class="col-6">
                                <div class="thumb-text">
                                    <h5>{{ $slider->title }}</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <img src="{{ $slider->image_path ? asset('storage/' . $slider->image_path) : 'https://via.placeholder.com/1200x800' }}" 
                                     alt="{{ $slider->title }}" class="thumb-image">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
</div>
@endsection
@section('content')
<div class="container mt-6">
    <h1>Каталог недвижимости</h1>

    <!-- Форма фильтров -->
    <form method="GET" action="{{ route('home') }}" class="mb-4">
        <div class="row g-3">
            <!-- Цена -->
            <div class="col-md-3">
                <label for="price_min" class="form-label">Цена, ₽ (мин)</label>
                <input type="number" name="price_min" id="price_min" class="form-control" value="{{ request('price_min') }}" placeholder="От">
            </div>
            <div class="col-md-3">
                <label for="price_max" class="form-label">Цена, ₽ (макс)</label>
                <input type="number" name="price_max" id="price_max" class="form-control" value="{{ request('price_max') }}" placeholder="До">
            </div>
            <!-- Площадь -->
            <div class="col-md-3">
                <label for="area_min" class="form-label">Площадь, м² (мин)</label>
                <input type="number" name="area_min" id="area_min" class="form-control" value="{{ request('area_min') }}" placeholder="От">
            </div>
            <div class="col-md-3">
                <label for="area_max" class="form-label">Площадь, м² (макс)</label>
                <input type="number" name="area_max" id="area_max" class="form-control" value="{{ request('area_max') }}" placeholder="До">
            </div>
            <!-- Комнаты -->
            <div class="col-md-3">
                <label for="rooms" class="form-label">Комнаты</label>
                <select name="rooms" id="rooms" class="form-select">
                    <option value="">Все</option>
                    <option value="1" {{ request('rooms') == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ request('rooms') == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ request('rooms') == '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ request('rooms') == '4' ? 'selected' : '' }}>4+</option>
                </select>
            </div>
            <!-- Тип недвижимости -->
            <div class="col-md-3">
                <label for="type" class="form-label">Тип недвижимости</label>
                <select name="type" id="type" class="form-select">
                    <option value="">Все</option>
                    <option value="квартира" {{ request('type') == 'квартира' ? 'selected' : '' }}>Квартира</option>
                    <option value="дом" {{ request('type') == 'дом' ? 'selected' : '' }}>Дом</option>
                    <option value="коммерческая" {{ request('type') == 'коммерческая' ? 'selected' : '' }}>Коммерческая</option>
                </select>
            </div>
            <!-- Кнопка -->
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Фильтровать</button>
            </div>
        </div>
    </form>

    <!-- Список недвижимости -->
    @include('components.property-list', ['properties' => $properties])
</div>
@endsection