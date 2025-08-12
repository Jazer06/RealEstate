@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container py-4 mt-6">
    <h1 class="text-3xl font-bold mb-4">Редактировать слайд</h1>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 dashboard-alert-success" role="alert" style="background-color: #704a4a; color: #e0e0e0; border: none;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1);"></button>
        </div>
    @endif

    <form action="{{ route('dashboard.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data" class="p-4" style="background-color: #3a3a3a; border-radius: 8px;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label text-light">Заголовок</label>
            <input type="text" name="title" class="form-control bg-dark text-light" value="{{ old('title', $slider->title) }}">
        </div>

        <div class="mb-3">
            <label for="subtitle" class="form-label text-light">Подпись</label>
            <input type="text" name="subtitle" class="form-control bg-dark text-light" value="{{ old('subtitle', $slider->subtitle) }}">
        </div>

        <div class="mb-3">
            <label for="button_text" class="form-label text-light">Текст кнопки</label>
            <input type="text" name="button_text" class="form-control bg-dark text-light" value="{{ old('button_text', $slider->button_text) }}">
        </div>

        <div class="mb-3">
            <label for="button_link" class="form-label text-light">Ссылка кнопки</label>
            <input type="url" name="button_link" class="form-control bg-dark text-light" value="{{ old('button_link', $slider->button_link) }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label text-light">Изображение</label>
            <input type="file" name="image" class="form-control bg-dark text-light">
            @if ($slider->image_path)
                <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}" class="img-thumbnail mt-2" style="max-width: 100px; height: auto; border: 1px solid #555;">
            @endif
        </div>
        <div class="mb-3">
            <label for="properties" class="form-label text-light">Привязка квартиры к опеределенному ЖК</label>
            <select name="properties[]" id="properties" class="form-control bg-dark text-light" multiple>
                @foreach ($allProperties as $property)
                    <option value="{{ $property->id }}"
                        @if ($slider->properties->contains($property->id)) selected @endif>
                        {{ $property->title }} — {{ number_format($property->price, 0, ',', ' ') }} ₽
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Удерживайте Ctrl (или Cmd на Mac), чтобы выбрать несколько</small>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary dashboard-btn-primary">Обновить</button>
            <a href="{{ route('dashboard.sliders.index') }}" class="btn btn-secondary bg-secondary text-white hover:bg-gray-600">Отмена</a>
        </div>
    </form>
</div>
@endsection
