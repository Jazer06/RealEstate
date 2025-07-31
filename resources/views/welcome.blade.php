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

<div class="container">
    @include('components.filters')
</div>
<div class="container mt-6">
    @include('components.property-list', ['properties' => $properties])
    @if($totalProperties === 0)
        <div class="alert alert-warning mt-4">
            По вашему запросу ничего не найдено.
        </div>
    @endif
</div>

@endsection


<style>
.filter-label {
    color: #6b7280;
    font-size: 0.9rem;
}

/* === Стили для select в стиле навбара === */
.navbar-select {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: none !important; /* Убираем границу */
    border-radius: 8px;
    color: #000;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%23000' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 10l3 3 3-3'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 12px;
}

/* Убираем стандартный outline, делаем свой при фокусе */
.navbar-select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.2);
    color: #000;
}


/* Дополнительно: если хочешь, чтобы при скролле он тоже менялся — можно добавить JS, но по умолчанию и так чёрный */

/* Стили для маленьких чёрных круглых ползунков */
.noUi-handle {
    width: 15px !important;     /* уменьшаем размер */
    height: 15px !important;    /* квадрат под border-radius */
    background: #000 !important; /* чёрный цвет */
    border: none !important;
    border-radius: 50% !important; /* делаем кругом */
    cursor: pointer;
    box-shadow: none !important;
    box-sizing: border-box;
    right: -13px !important;

    /* Центрируем относительно шкалы */
    top: -6px !important; /* приподнимаем, чтобы был по центру 1px линии */
}

/* Убираем внутренние элементы (стрелки/плюсы по умолчанию) */
.noUi-handle:before,
.noUi-handle:after {
    display: none !important;
}

/* Опционально: тень или обводка для лучшей видимости */
.noUi-handle:hover,
.noUi-handle:active {
    transform: scale(1.2); /* лёгкий эффект при наведении */
    background: #333 !important;
}

.noUi-connect {
    background: #a78bfa !important;
    opacity: 0.7 !important;
    border-radius: 2px !important;
}

/* Убираем заливку фона у всей шкалы и делаем тонкую чёрную линию */
.noUi-base {
    background: transparent !important; /* убираем заливку */
}

/* Основная шкала — чёрная линия толщиной 1px */
.noUi-horizontal {
    height: 3px !important;
    border-radius: 0 !important; /* убираем скругления, если нужно */
}

/* Дополнительно: убедимся, что .noUi-base не добавляет фона */
.noUi-target {
    background: transparent !important;
    box-shadow: none !important;
    border: 1px solid black;!important;

}


.room-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    gap: 0.75rem;
    align-items: center;
}

.room-button, .room-button-text {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    cursor: pointer;
    background: #fff;
    color: #a78bfa;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.room-button {
    width: 2.5rem;
    height: 2.5rem;
    border: 1px solid #a78bfa;
}

.room-button-text {
    width: 3rem; /* Увеличенный размер для "Студия" */
    height: 3rem;
    border: none;
}

.room-button input, .room-button-text input {
    display: none;
}

.room-button span, .room-button-text span {
    pointer-events: none;
    text-align: center;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.room-button span {
    font-size: 0.9rem;
}

.room-button-text span {
    font-size: 0.8rem; /* Меньший шрифт для "Студия" */
}

.room-button input:checked + span {
    background: #a78bfa;
    color: white;
    border: 1px solid #a78bfa;
}

.room-button-text input:checked + span {
    background: #a78bfa;
    color: white;
    border: 1px solid #7c3aed; /* Контрастный бордер для чёткости */
}

.text-small {
    font-size: 0.9rem;
}

.btn-show, .btn-reset {
    background-color: #a78bfa;
    color: white;
    border: none;
    padding: 0.75rem 1rem;
    border-radius: 20px;
    font-size: 1rem;
    position: relative;
    transition: background-color 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-show::after {
    content: '›';
    margin-left: 0.5rem;
}


.btn-reset {
    background-color: #f87171; /* Красный для сброса */
}

.btn-reset:hover {
    background-color: #ef4444;
}

.btn-reset svg {
    width: 16px;
    height: 16px;
}


</style>