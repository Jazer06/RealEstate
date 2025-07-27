@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление объектами</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('dashboard.properties.create') }}" class="btn btn-primary mb-3">Добавить объект</a>
    @if ($properties->isNotEmpty())
        <div class="row">
            @foreach ($properties as $property)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="{{ $property->image ? asset('storage/' . $property->image) : 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $property->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $property->title }}</h5>
                            <p class="card-text">{{ $property->address }}</p>
                            <p class="card-text">Цена: {{ number_format($property->price, 0, ',', ' ') }} ₽</p>
                            <a href="{{ route('dashboard.properties.edit', $property) }}" class="btn btn-warning btn-sm">Редактировать</a>
                            <form action="{{ route('dashboard.properties.destroy', $property) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Объектов нет. Добавьте новый!</p>
    @endif
</div>
@endsection