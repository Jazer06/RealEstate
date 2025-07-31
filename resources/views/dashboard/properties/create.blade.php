@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container py-4 mt-6">
    <h1 class="text-2xl font-bold mb-4">Добавить объект</h1>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 dashboard-alert-success"
             style="background-color: #704a4a; color: #e0e0e0; border: none;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1);"></button>
        </div>
    @endif

    <form action="{{ route('dashboard.properties.store') }}" method="POST" enctype="multipart/form-data" class="p-4" style="background-color: #3a3a3a; border-radius: 8px;">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label for="title" class="form-label text-light">Название</label>
                <input type="text" name="title" id="title" class="form-control bg-dark text-light" value="{{ old('title') }}">
                @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="price" class="form-label text-light">Цена, ₽</label>
                <input type="number" name="price" id="price" class="form-control bg-dark text-light" value="{{ old('price') }}">
                @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="address" class="form-label text-light">Адрес</label>
                <input type="text" name="address" id="address" class="form-control bg-dark text-light" value="{{ old('address') }}">
                @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="area" class="form-label text-light">Площадь, м²</label>
                <input type="number" step="0.1" name="area" id="area" class="form-control bg-dark text-light" value="{{ old('area') }}">
                @error('area') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="rooms" class="form-label text-light">Комнаты</label>
                <select name="rooms" id="rooms" class="form-select bg-dark text-light">
                    <option value="">Выберите</option>
                    <option value="0" {{ old('rooms') === '0' ? 'selected' : '' }}>Студия</option>
                    <option value="1" {{ old('rooms') == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('rooms') == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ old('rooms') == '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ old('rooms') == '4' ? 'selected' : '' }}>4+</option>
                </select>
                @error('rooms') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="type" class="form-label text-light">Тип</label>
                <select name="type" id="type" class="form-select bg-dark text-light">
                    <option value="">Выберите тип</option>
                    <option value="квартира" {{ old('type') == 'квартира' ? 'selected' : '' }}>Квартира</option>
                    <option value="дом" {{ old('type') == 'дом' ? 'selected' : '' }}>Дом</option>
                    <option value="коммерческая" {{ old('type') == 'коммерческая' ? 'selected' : '' }}>Коммерческая</option>
                </select>
                @error('type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label text-light">Описание</label>
                <textarea name="description" id="description" class="form-control bg-dark text-light" rows="3">{{ old('description') }}</textarea>
                @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="image_path" class="form-label text-light">Основное фото</label>
                <input type="file" name="image_path" id="image_path" class="form-control bg-dark text-light" accept="image/*">
                @error('image_path') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="plan_image" class="form-label text-light">План дома</label>
                <input type="file" name="plan_image" id="plan_image" class="form-control bg-dark text-light" accept="image/*">
                @error('plan_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="additional_images" class="form-label text-light">Дополнительные фото (до 5)</label>
                <input type="file" name="additional_images[]" id="additional_images" class="form-control bg-dark text-light" multiple accept="image/*">
                @error('additional_images.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary dashboard-btn-primary">Создать объект</button>
            <a href="{{ route('dashboard.properties.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection