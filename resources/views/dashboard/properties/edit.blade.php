@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать объект</h1>
    <form action="{{ route('dashboard.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Название</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $property->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $property->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Цена (₽)</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price', $property->price) }}" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Адрес</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $property->address) }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Картинка</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            @if ($property->image)
                <img src="data:image/jpeg;base64,{{ $property->image }}" alt="{{ $property->title }}" style="max-width: 200px; margin-top: 10px;">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
</div>
@endsection