@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать объект</h1>
    <form action="{{ route('dashboard.properties.update', $property) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Название</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $property->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" id="description" class="form-control" required>{{ $property->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Цена (₽)</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $property->price }}" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Адрес</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $property->address }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
</div>
@endsection