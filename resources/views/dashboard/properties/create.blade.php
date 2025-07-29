@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавить объект</h1>
    <form method="POST" action="{{ route('dashboard.properties.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Название</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Цена, ₽</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Адрес</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="area" class="form-label">Площадь, м²</label>
            <input type="number" name="area" id="area" class="form-control" value="{{ old('area') }}">
            @error('area') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="rooms" class="form-label">Комнаты</label>
            <input type="number" name="rooms" id="rooms" class="form-control" value="{{ old('rooms') }}">
            @error('rooms') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Тип</label>
            <select name="type" id="type" class="form-select">
                <option value="">Выберите тип</option>
                <option value="квартира" {{ old('type') == 'квартира' ? 'selected' : '' }}>Квартира</option>
                <option value="дом" {{ old('type') == 'дом' ? 'selected' : '' }}>Дом</option>
                <option value="коммерческая" {{ old('type') == 'коммерческая' ? 'selected' : '' }}>Коммерческая</option>
            </select>
            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="image_path" class="form-label">Основное фото</label>
            <input type="file" name="image_path" id="image_path" class="form-control">
            @error('image_path') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="additional_images" class="form-label">Дополнительные фото</label>
            <input type="file" name="additional_images[]" id="additional_images" class="form-control" multiple>
            @error('additional_images.*') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
</div>
@endsection