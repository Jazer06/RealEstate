@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container py-4 mt-5">
    <h1 class="text-3xl font-bold mb-4">Редактировать ЖК</h1>

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

    <form id="slider-update-form"
          action="{{ route('dashboard.sliders.update', $slider) }}"
          method="POST"
          enctype="multipart/form-data"
          class="p-4"
          style="background-color: #3a3a3a; border-radius: 8px;"
          novalidate>

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
            <label for="adress" class="form-label text-light">Адрес</label>
            <textarea name="adress" class="form-control bg-dark text-light" rows="3">{{ old('adress', $slider->adress) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="button_text" class="form-label text-light">Текст кнопки</label>
            <input type="text" name="button_text" class="form-control bg-dark text-light" value="{{ old('button_text', $slider->button_text) }}" required>
        </div>

        <input type="hidden" name="button_link" value="{{ old('button_link', $slider->button_link ?? '') }}">

        <div class="mb-3">
            <label for="image" class="form-label text-light">Основное изображение</label>
            @if ($slider->image_path)
                <div class="mb-2">
                    <img src="{{ Storage::url($slider->image_path) }}" alt="Current Image" style="max-width: 200px; border-radius: 4px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control bg-dark text-light" accept="image/*">
            <small class=" text-light">Максимальный размер: 15 МБ. Оставьте пустым, если не хотите менять изображение.</small>
        </div>

        <div class="mb-3">
            <label for="video" class="form-label text-light">Видео</label>
            @if ($slider->video_path)
                <div class="mb-2">
                    <video controls style="max-width: 200px; border-radius: 4px;">
                        <source src="{{ Storage::url($slider->video_path) }}" type="video/mp4">
                        Ваш браузер не поддерживает видео.
                    </video>
                    <button type="button"
                            class="btn btn-danger text-white px-2 py-1 rounded delete-video"
                            style="font-size: 0.8rem;"
                            data-slider-id="{{ $slider->id }}"
                            data-url="{{ route('dashboard.sliders.video.destroy', $slider->id) }}">Удалить видео</button>
                </div>
            @endif
            <input type="file" name="video" class="form-control bg-dark text-light" accept="video/*">
            <small class="text-light">Максимальный размер: 20 МБ. Оставьте пустым, если не хотите менять видео.</small>
        </div>

        <div class="mb-3">
            <label for="additional_images" class="form-label text-light">Дополнительные изображения</label>
            <input type="file" name="additional_images[]" class="form-control bg-dark text-light" multiple accept="image/*">
            <small class="text-light">Максимальный размер каждого файла: 15 МБ.</small>

            @if ($slider->images->count() > 0)
                <div class="mt-2">
                    <h6 class="text-light mb-2">Текущие дополнительные изображения:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($slider->images as $image)
                            <div class="position-relative" id="image-{{ $image->id }}">
                                <img src="{{ Storage::url($image->image_path) }}" alt="Additional Image" style="max-width: 100px; border-radius: 4px;">
                                <button type="button"
                                        class="btn btn-danger text-white px-2 py-1 rounded delete-image"
                                        style="font-size: 0.8rem;"
                                        data-image-id="{{ $image->id }}"
                                        data-url="{{ route('dashboard.sliders.image.destroy', $image->id) }}">Удалить</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary dashboard-btn-primary">Сохранить</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Удаление дополнительного изображения
        document.querySelectorAll('.delete-image').forEach(button => {
            button.addEventListener('click', function () {
                if (confirm('Вы уверены, что хотите удалить это изображение?')) {
                    const imageId = this.getAttribute('data-image-id');
                    const url = this.getAttribute('data-url');
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`image-${imageId}`).remove();
                            alert(data.message);
                        } else {
                            alert('Ошибка: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('Ошибка: ' + error.message);
                    });
                }
            });
        });

        // Удаление видео
        document.querySelectorAll('.delete-video').forEach(button => {
            button.addEventListener('click', function () {
                if (confirm('Вы уверены, что хотите удалить это видео?')) {
                    const sliderId = this.getAttribute('data-slider-id');
                    const url = this.getAttribute('data-url');
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.parentElement.remove();
                            alert(data.message);
                        } else {
                            alert('Ошибка: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('Ошибка: ' + error.message);
                    });
                }
            });
        });
    });
</script>
@endsection