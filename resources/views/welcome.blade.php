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
        <div class="carousel-nav-buttons">
            <button class="carousel-nav-btn up">→</button>
            <button class="carousel-nav-btn down">←</button>
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
<div class="container">
    <h1>Добро пожаловать!</h1>
    <p>Это контент внутри container.</p>
</div>
@endsection


<style>

/* ========================== */
/* СТИЛИ КАРУСЕЛИ С МИНИАТЮРАМИ */
/* ========================== */








</style>
