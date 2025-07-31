@extends('layouts.app')

@section('carousel')
<div class="full-screen-carousel">
    <div class="carousel-inner">
        @foreach ($sliders as $slider)
            <div class="carousel-slide">
                <img src="{{ $slider->image_path ? asset('storage/' . $slider->image_path) : 'https://via.placeholder.com/1200x800' }}" 
                     alt="{{ $slider->title }}" class="carousel-image">
                <div class="container">
                    <div class="slide-content glass-effect">
                        <h1 class="slide-title">{{ $slider->title }}</h1>
                        <p class="slide-subtitle">{{ $slider->subtitle }}</p>
                        <a href="{{ $slider->button_link }}" class="btn-iphone">{{ $slider->button_text }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="container">
    <div class="carousel-nav-buttons d-sm-block d-none">
        <button class="carousel-nav-btn carousel-nav-prev">←</button>
        <button class="carousel-nav-btn carousel-nav-next">→</button>
    </div>
    <div class="row">
        <div class="custom-thumbs-container">
            @foreach ($sliders as $index => $slider)
                <div class="thumb-item {{ $loop->first ? 'active' : '' }}" data-slide-index="{{ $index }}">
                    <div class="thumb-content glass-effect">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <div class="thumb-text">
                                    <h5>{{ $slider->title }}</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <img src="{{ $slider->image_path ? asset('storage/' . $slider->image_path) : 'https://via.placeholder.com/1200x800' }}" 
                                     alt="{{ $slider->title }}" class="thumb-image hover-scale-banner">
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
    @include('components.filters')
    @include('components.property-list', ['properties' => $properties])
    @if($totalProperties === 0)
        <div class="alert alert-warning mt-4 glass-effect-banner">
            По вашему запросу ничего не найдено.
        </div>
    @endif
    @include('components.banner')
    @include('components.contacts-form')

@endsection
