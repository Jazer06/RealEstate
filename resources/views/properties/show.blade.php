@extends('layouts.app')

@section('content')
<div class="container custom-property-container mt-9">
    <h1 class="custom-title mt-3">{{ $property->title }}</h1>
    <div class="row">
        <!-- Слайдер с фото -->
        <div class="col-md-12">
            <div class="custom-slider-wrapper shadow-sm">
                <div class="custom-slider">
                    @php
                        $allImages = [];
                        $hasPlan = $property->images()->where('is_plan', true)->first() !== null;
                        // Основное фото
                        if ($property->image_path) {
                            $allImages[] = [
                                'url' => asset('storage/' . $property->image_path),
                                'alt' => $property->title,
                                'type' => 'main'
                            ];
                        }
                        // План дома
                        $planImage = $property->images()->where('is_plan', true)->first();
                        if ($planImage) {
                            $allImages[] = [
                                'url' => asset('storage/' . $planImage->image_path),
                                'alt' => $property->title . ' - план дома',
                                'type' => 'plan'
                            ];
                        }
                        // Доп. фото
                        foreach ($property->images()->where('is_plan', false)->get() as $img) {
                            $allImages[] = [
                                'url' => asset('storage/' . $img->image_path),
                                'alt' => $property->title . ' - фото',
                                'type' => 'gallery'
                            ];
                        }
                    @endphp

                    @if(count($allImages) > 0)
                        @foreach($allImages as $index => $image)
                            <div class="custom-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" data-type="{{ $image['type'] }}">
                                <img src="{{ $image['url'] }}" 
                                     alt="{{ $image['alt'] }}" 
                                     class="img-fluid custom-slide-image">
                                <!-- Бирка "План дома" -->
                                @if($image['type'] === 'plan')
                                    <div class="slide-badge">
                                        📐 План дома
                                    </div>
                                @elseif($index === 0 && !$hasPlan)
                                    <div class="slide-badge">
                                         📐 План дома
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="custom-slide active">
                            <img src="https://via.placeholder.com/600x400?text=Нет+фото" 
                                 alt="Нет фото" 
                                 class="img-fluid custom-slide-image">
                            <!-- Значок 📐 для первой картинки, если нет плана и нет других фото -->
                            <div class="slide-badge">
                                📐
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Миниатюры -->
                <div class="custom-thumbnails">
                    @foreach($allImages as $index => $image)
                        <div class="thumb-container" data-index="{{ $index }}">
                            @if($image['type'] === 'plan')
                                <!-- Только для плана — рамка и бейдж -->
                                <div class="thumb-wrapper border border-primary rounded">
                                    <div class="thumb-badge-label bg-primary text-white">
                                        📐 План
                                    </div>
                                    <div class="custom-thumb"
                                         style="background-image: url('{{ $image['url'] }}');"
                                         title="План дома">
                                    </div>
                                </div>
                            @else
                                <!-- Обычные фото — без рамки -->
                                <div class="thumb-wrapper">
                                    @if($index === 0 && !$hasPlan)
                                        <div class="thumb-badge-label bg-primary text-white">
                                            📐
                                        </div>
                                    @endif
                                    <div class="custom-thumb"
                                         style="background-image: url('{{ $image['url'] }}');"
                                         title="Фото">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="custom-property-info info-card depth-card position-relative">

                <!-- Кнопка "в избранное" в углу -->
                <div class="card-footer-button"
                     style="position: absolute; top: 0px; right: 0px; padding: 10px; z-index: 10;"
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

                <!-- Параметры (в одну или две строки) -->
                <div class="d-flex flex-wrap gap-3 mb-2">
                    <!-- Цена -->
                    <div class="d-flex align-items-center">
                        <svg class="me-2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #e74c3c;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M16 8h-6a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h6"></path>
                            <path d="M16 10v4"></path>
                        </svg>
                        @if($property->price > 0)
                            <strong>Цена: {{ number_format($property->price, 0, ' ', ' ') }} ₽</strong>
                        @else
                            <strong>Цена: <a href="{{ route('consultation') }}" class="btn btn-outline-secondary">Узнать цену</a></strong>
                        @endif
                    </div>

                    <!-- Площадь -->
                    @if($property->area)
                        <div class="d-flex align-items-center">
                            <svg class="me-2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #3498db;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="3" x2="9" y2="21"></line>
                            </svg>
                            <strong>Площадь:</strong>
                            <span class="ms-1">{{ $property->area }} м²</span>
                        </div>
                    @endif

                    <!-- Комнаты -->
                    @if($property->rooms)
                        <div class="d-flex align-items-center">
                            <svg class="me-2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #2ecc71;">
                                <path d="M2 12h20"></path>
                                <path d="M2 18h20"></path>
                                <path d="M2 6h20"></path>
                                <path d="M6 6v12"></path>
                                <path d="M18 6v12"></path>
                            </svg>
                            <strong>Комнаты:</strong>
                            <span class="ms-1">{{ $property->rooms }}</span>
                        </div>
                    @endif

                    <!-- Тип -->
                    @if($property->type)
                        <div class="d-flex align-items-center">
                            <svg class="me-2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #9b59b6;">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <strong>Тип:</strong>
                            <span class="ms-1">{{ $property->type }}</span>
                        </div>
                    @endif
                </div>

                <!-- Адрес — отдельная строка -->
                @if($property->address)
                    <div class="d-flex align-items-center mb-2">
                        <svg class="me-2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #f39c12;">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <strong>Адрес:</strong>
                        <span class="ms-1 text-truncate" style="max-width: 100%; word-break: break-word;">
                            {{ $property->address }}
                        </span>
                    </div>
                @endif

                <!-- Описание -->
                <div class="d-flex align-items-start">
                    <svg class="me-2 mt-1" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #7f8c8d;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <strong>Описание:</strong>
                    <span class="ms-1" style="white-space: pre-line;">{{ $property->description ?? 'Нет описания' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection