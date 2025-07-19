@extends('layouts.app')

@section('carousel')
<div class="full-screen-carousel">
    <div>
        <img src="https://guxzs9e8qz.a.trbcdn.net/ioss(resize=x1200)/upload/iblock/fd8/fd89c30c4ad496c5d8301696ff8d8d0b/e1247bc08e50a836d056c9cf4b44a0f7.jpg" alt="Slide 1">
        <div class="slide-content">
            <a href="https://example.com/slide1" class="iphone-button">Узнать больше</a>
            <p class="slide-description">Познакомьтесь с проектом MR</p>
        </div>
    </div>
    <div>
        <img src="https://guxzs9e8qz.a.trbcdn.net/ioss(resize=x1200)/upload/iblock/885/885f12df4a1a19883c202741e7147301/84a7418fead6db98f14cad91c986bbef.jpg" alt="Slide 2">
        <div class="slide-content">
            <a href="https://example.com/slide2" class="iphone-button">Подробнее</a>
            <p class="slide-description">Информация о следующем объекте</p>
        </div>
    </div>
</div>

<!-- Подключаем стили Slick Slider -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />

<!-- Подключаем jQuery и Slick JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

<!-- Инициализация карусели -->
<script>
    $(document).ready(function(){
        console.log('jQuery loaded:', typeof $ !== 'undefined');
        console.log('Slick loaded:', typeof $.fn.slick !== 'undefined');
        $('.full-screen-carousel').slick({
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
        $('.full-screen-carousel').on('click', '.slick-slide', function(){
            $('.full-screen-carousel').slick('slickNext');
        });
    });
</script>

<style>

</style>
@endsection

@section('content')
<div class="container">
    <h1>Добро пожаловать!</h1>
    <p>Это контент внутри container.</p>
</div>
@endsection