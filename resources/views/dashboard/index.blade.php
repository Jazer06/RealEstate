@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление слайдерами</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('dashboard.sliders.create') }}" class="btn btn-primary mb-3">Добавить слайд</a>
    <table class="table">
        <thead>
            <tr>
                <th>Заголовок</th>
                <th>Подпись</th>
                <th>Текст кнопки</th>
                <th>Ссылка</th>
                <th>Изображение</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $slider)
                <tr>
                    <td>{{ $slider->title }}</td>
                    <td>{{ $slider->subtitle }}</td>
                    <td>{{ $slider->button_text }}</td>
                    <td>{{ $slider->button_link }}</td>
                    <td>
                        @if ($slider->image_path)
                            <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}" width="100">
                        @else
                            Нет изображения
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('dashboard.sliders.edit', $slider) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        <form action="{{ route('dashboard.sliders.destroy', $slider) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection