@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Избранное</h1>
    <div class="row">
        @forelse ($favorites as $property)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/300x200' }}" 
                         class="card-img-top" 
                         alt="{{ $property->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $property->title }}</h5>
                        <p class="card-text">
                            Цена: {{ number_format($property->price, 0, '.', ' ') }} ₽<br>
                            @if($property->area) Площадь: {{ $property->area }} м²<br> @endif
                            @if($property->rooms) Комнат: {{ $property->rooms }}<br> @endif
                            @if($property->type) Тип: {{ $property->type }}<br> @endif
                            Адрес: {{ $property->address ?? 'Не указан' }}
                        </p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.properties.show', $property->id) }}" class="btn btn-primary">Подробнее</a>
                            <form action="{{ route('favorites.toggle', $property->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    Убрать из избранного
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>У вас нет избранной недвижимости.</p>
        @endforelse
    </div>

    <!-- Пагинация -->
    <div class="d-flex justify-content-center">
        {{ $favorites->links() }}
    </div>
</div>
@endsection