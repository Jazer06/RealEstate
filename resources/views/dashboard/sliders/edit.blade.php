
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать слайд</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('dashboard.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title) }}">
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label">Подпись</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle) }}">
        </div>
        <div class="mb-3">
            <label for="button_text" class="form-label">Текст кнопки</label>
            <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $slider->button_text) }}">
        </div>
        <div class="mb-3">
            <label for="button_link" class="form-label">Ссылка кнопки</label>
            <input type="url" name="button_link" class="form-control" value="{{ old('button_link', $slider->button_link) }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Изображение</label>
            <input type="file" name="image" class="form-control">
            @if ($slider->image_path)
                <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}" width="100" class="mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
        <a href="{{ route('dashboard.sliders.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection