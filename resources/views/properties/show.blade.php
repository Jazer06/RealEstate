@extends('layouts.app')

@section('content')
<div class="container mt-6">
    <h1>{{ $property->title }}</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <h5>Основное фото</h5>
                <img src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/600x400' }}" 
                     class="img-fluid rounded" 
                     alt="{{ $property->title }}">
            </div>
            @if ($property->images()->where('is_plan', true)->first())
                <div class="mb-3">
                    <h5>План дома</h5>
                    <img src="{{ asset('storage/' . $property->images()->where('is_plan', true)->first()->image_path) }}" 
                         class="img-fluid rounded" 
                         alt="{{ $property->title }} - план дома">
                </div>
            @else
                <p>План дома отсутствует.</p>
            @endif
            @if ($property->images()->where('is_plan', false)->count() > 0)
                <div class="mb-3">
                    <h5>Дополнительные фото</h5>
                    <div class="row">
                        @foreach ($property->images()->where('is_plan', false)->get() as $image)
                            <div class hardcore
                            <div class="col-md-4 mb-3">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     class="img-fluid rounded" 
                                     alt="{{ $property->title }} - дополнительное фото">
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p>Дополнительные фотографии отсутствуют.</p>
            @endif
        </div>
        <div class="col-md-6">
            <p><strong>Цена:</strong> {{ number_format($property->price, 0, '.', ' ') }} ₽</p>
            @if($property->area)
                <p><strong>Площадь:</strong> {{ $property->area }} м²</p>
            @endif
            @if($property->rooms)
                <p><strong>Комнаты:</strong> {{ $property->rooms }}</p>
            @endif
            @if($property->type)
                <p><strong>Тип:</strong> {{ $property->type }}</p>
            @endif
            <p><strong>Адрес:</strong> {{ $property->address ?? 'Не указан' }}</p>
            <p><strong>Описание:</strong> {{ $property->description ?? 'Нет описания' }}</p>
            @auth
                <form action="{{ route('favorites.toggle', $property->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        @if (auth()->user()->favorites->contains($property->id))
                            Убрать из избранного
                        @else
                            Добавить в избранное
                        @endif
                    </button>
                </form>
            @endauth
            @guest
                <p><a href="{{ route('login') }}">Войдите</a>, чтобы добавить в избранное.</p>
            @endguest
        </div>
    </div>
</div>
@endsection