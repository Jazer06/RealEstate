@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container py-4 mt-5">
    <h1 class="text-3xl font-bold mb-4">Добавить новый слайд</h1>

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

    <form action="{{ route('dashboard.sliders.store') }}" method="POST" enctype="multipart/form-data" class="p-4" style="background-color: #3a3a3a; border-radius: 8px;">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label text-light">Заголовок</label>
            <input type="text" name="title" class="form-control bg-dark text-light" value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="subtitle" class="form-label text-light">Подпись</label>
            <input type="text" name="subtitle" class="form-control bg-dark text-light" value="{{ old('subtitle') }}">
        </div>

        <div class="mb-3">
            <label for="button_text" class="form-label text-light">Текст кнопки</label>
            <input type="text" name="button_text" class="form-control bg-dark text-light" value="{{ old('button_text') }}">
        </div>

        <div class="mb-3">
            <input type="hidden" name="button_link" class="form-control bg-dark text-light" value="{{ old('button_link') }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label text-light">Основное изображение</label>
            <input type="file" name="image" class="form-control bg-dark text-light">
            <small class="text-muted">Максимальный размер: 15 МБ.</small>
        </div>

        <div class="mb-3">
            <label for="additional_images" class="form-label text-light">Дополнительные изображения</label>
            <input type="file" name="additional_images[]" class="form-control bg-dark text-light" multiple>
            <small class="text-muted">Максимальный размер каждого файла: 15 МБ.</small>
        </div>

        <div class="mb-3">
            <label for="properties" class="form-label text-light">Кнопка ведёт на ЖК</label>
            <select name="properties[]" id="properties" class="form-control bg-dark text-light" multiple>
                <option value="" selected>Ведём на все ЖК</option>
                @foreach ($allProperties as $property)
                    <option value="{{ $property->id }}">{{ $property->name }}</option>
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