
@extends('layouts.app')

@section('title', 'Объекты недвижимости')

@section('content')

<h2 class="mb-4 mt-6">Наши объекты недвижимости</h2>

<div class="row">
@forelse ($properties as $property)
    <div class="col-md-4 mb-4">
        <div class="card h-100" onclick="window.location='{{ route('properties.show', $property->id) }}'" style="cursor: pointer;">
            <img src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/300x200' }}"
                 class="card-img-top"
                 alt="{{ $property->title }}"
                 style="height: 200px; object-fit: cover;">

            <div class="card-body">
                <h5 class="card-title">{{ $property->title }}</h5>
                <p class="card-text text-muted">
                    <strong>{{ number_format($property->price, 0, ' ', ' ') }} ₽</strong><br>
                    @if($property->area) Площадь: {{ $property->area }} м² <br> @endif
                    @if($property->rooms) Комнат: {{ $property->rooms }} <br> @endif
                    @if($property->type) Тип: {{ $property->type }} <br> @endif
                    <small>{{ $property->address ?? 'Адрес не указан' }}</small>
                </p>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <p class="text-muted">Объекты пока не добавлены.</p>
    </div>
@endforelse
</div>

<div class="pagination-container mt-4">
@if ($properties->hasPages())
    {{ $properties->links('pagination::bootstrap-5') }}
@endif
</div>
@endsection