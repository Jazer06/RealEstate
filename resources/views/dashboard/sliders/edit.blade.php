@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container py-4 mt-5">
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
            <input type="text" name="title" class="form-control bg-dark text-light" value="{{ old('title', $slider->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="subtitle" class="form-label text-light">Подпись</label>
            <input type="text" name="subtitle" class="form-control bg-dark text-light" value="{{ old('subtitle', $slider->subtitle) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label text-light">Описание</label>
            <textarea name="description" class="form-control bg-dark text-light" rows="5">{{ old('description', $slider->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="button_text" class="form-label text-light">Текст кнопки</label>
            <input type="text" name="button_text" class="form-control bg-dark text-light" value="{{ old('button_text', $slider->button_text) }}" required>
        </div>

        <div class="mb-3">
            <input type="hidden" name="button_link" class="form-control bg-dark text-light" value="{{ old('button_link', $slider->button_link ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label text-light">Основное изображение</label>
            @if ($slider->image_path)
                <div class="mb-2">
                    <img src="{{ Storage::url($slider->image_path) }}" alt="Current Image" style="max-width: 200px; border-radius: 4px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control bg-dark text-light">
            <small class="text-muted">Максимальный размер: 15 МБ. Оставьте пустым, если не хотите менять изображение.</small>
        </div>

        <div class="mb-3">
            <label for="additional_images" class="form-label text-light">Дополнительные изображения</label>
            <input type="file" name="additional_images[]" class="form-control bg-dark text-light" multiple>
            <small class="text-muted">Максимальный размер каждого файла: 15 МБ.</small>
            @if ($slider->images->count() > 0)
                <div class="mt-2">
                    <h6 class="text-light mb-2">Текущие дополнительные изображения:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($slider->images as $image)
                            <div class="position-relative">
                                <img src="{{ Storage::url($image->image_path) }}" alt="Additional Image" style="max-width: 100px; border-radius: 4px;">
                                <form action="{{ route('dashboard.sliders.image.destroy', $image->id) }}" method="POST" style="position: absolute; top: 0; right: 0;" class="m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-white px-2 py-1 rounded" style="font-size: 0.8rem;">Удалить</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <small class="text-muted">Загрузите новые или оставьте как есть.</small>
        </div>

        <div class="mb-3">
            <label for="properties" class="form-label text-light">Кнопка ведёт на ЖК</label>
            <select name="properties[]" id="properties" class="form-control bg-dark text-light" multiple>
                <option value="" {{ empty($slider->properties->pluck('id')->toArray()) ? 'selected' : '' }}>Ведём на все ЖК</option>
                @foreach ($allProperties as $property)
                    <option value="{{ $property->id }}" {{ in_array($property->id, $slider->properties->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $property->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary dashboard-btn-primary">Сохранить</button>
            <a href="{{ route('dashboard.sliders.index') }}" class="btn btn-secondary bg-secondary text-white hover:bg-gray-600">Отмена</a>
        </div>
    </form>
</div>
@endsection

