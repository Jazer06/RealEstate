@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Мои объекты</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('dashboard.properties.create') }}" class="btn btn-primary mb-3">Добавить объект</a>
    <div class="row">
        @foreach ($properties as $property)
            <div class="col-md-4 mb-3">
                <div class="card">
                    @if ($property->image)
                        <img src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->title }}" class="card-img-top" style="max-height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top" style="height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">Нет изображения</div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $property->title }}</h5>
                        <p class="card-text">{{ $property->description }}</p>
                        <p class="card-text">Цена: {{ $property->price }} ₽</p>
                        <p class="card-text">Адрес: {{ $property->address }}</p>
                        <a href="{{ route('dashboard.properties.edit', $property->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        <form action="{{ route('dashboard.properties.destroy', $property->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Удалить объект?')">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection