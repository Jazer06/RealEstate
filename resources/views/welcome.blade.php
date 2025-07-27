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

@endsection
@section('content')
<div class="container">
    <h1>Добро пожаловать!</h1>
    <p>Это контент внутри container.</p>
</div>
@endsection

<!-- Инициализация карусели -->
<script>
    $(document).ready(function(){
        console.log('jQuery loaded:', typeof $ !== 'undefined');
        console.log('Slick loaded:', typeof $.fn.slick !== 'undefined');
        $('.carousel-inner').slick({
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            dots: false,
            fade: true,
            speed: 800,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });

        // Листание по клику на слайд
        $('.carousel-inner').on('click', '.slick-slide', function(){
            $('.carousel-inner').slick('slickNext');
        });
    });
</script>