@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавить новый слайд</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('dashboard.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label">Подпись</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
        </div>
        <div class="mb-3">
            <label for="button_text" class="form-label">Текст кнопки</label>
            <input type="text" name="button_text" class="form-control" value="{{ old('button_text') }}">
        </div>
        <div class="mb-3">
            <label for="button_link" class="form-label">Ссылка кнопки</label>
            <input type="url" name="button_link" class="form-control" value="{{ old('button_link') }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Изображение</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('dashboard.sliders.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection