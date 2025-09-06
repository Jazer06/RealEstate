{{-- resources/views/dashboard/properties/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container py-4 mt-6">
    <h1 class="text-2xl font-bold mb-4">Редактировать объект</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 dashboard-alert-success"
             style="background-color: #2f5d3a; color: #e0e0e0; border: none;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1);"></button>
        </div>
    @endif

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

    <form action="{{ route('dashboard.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="p-4" style="background-color: #3a3a3a; border-radius: 8px;">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label for="title" class="form-label text-light">Название</label>
                <input type="text" name="title" id="title" class="form-control bg-dark text-light" value="{{ old('title', $property->title) }}">
                @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="price" class="form-label text-light">Цена, ₽ Указываем 0, если хотим кнопку подробнее</label>
                <input type="number" name="price" id="price" class="form-control bg-dark text-light" value="{{ old('price', $property->price) }}">
                @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="address" class="form-label text-light">Адрес</label>
                <input type="text" name="address" id="address" class="form-control bg-dark text-light" value="{{ old('address', $property->address) }}">
                @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="area" class="form-label text-light">Площадь, м²</label>
                <input type="number" step="0.1" name="area" id="area" class="form-control bg-dark text-light" value="{{ old('area', $property->area) }}">
                @error('area') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="rooms" class="form-label text-light">Комнаты</label>
                <select name="rooms" id="rooms" class="form-select bg-dark text-light">
                    <option value="">Выберите</option>
                    <option value="0" {{ (string)old('rooms', $property->rooms) === '0' ? 'selected' : '' }}>Студия</option>
                    <option value="1" {{ (string)old('rooms', $property->rooms) === '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ (string)old('rooms', $property->rooms) === '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ (string)old('rooms', $property->rooms) === '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ (string)old('rooms', $property->rooms) === '4' ? 'selected' : '' }}>4+</option>
                </select>
                @error('rooms') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="type" class="form-label text-light">Тип</label>
                <select name="type" id="type" class="form-select bg-dark text-light">
                    <option value="">Выберите тип</option>
                    <option value="квартира" {{ old('type', $property->type) === 'квартира' ? 'selected' : '' }}>Квартира</option>
                    <option value="дом" {{ old('type', $property->type) === 'дом' ? 'selected' : '' }}>Дом</option>
                    <option value="коммерческая" {{ old('type', $property->type) === 'коммерческая' ? 'selected' : '' }}>Коммерческая</option>
                </select>
                @error('type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="slider_id" class="form-label text-light">Жилой комплекс</label>
                <select name="slider_id" id="slider_id" class="form-select bg-dark text-light">
                    <option value="">Без привязки</option>
                    @isset($sliders)
                        @foreach ($sliders as $slider)
                            <option value="{{ $slider->id }}" {{ (string)old('slider_id', $property->slider_id) === (string)$slider->id ? 'selected' : '' }}>
                                {{ $slider->title }}
                            </option>
                        @endforeach
                    @endisset
                </select>
                @error('slider_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label text-light">Описание</label>
                <textarea name="description" id="description" class="form-control bg-dark text-light" rows="3">{{ old('description', $property->description) }}</textarea>
                @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="image_path" class="form-label text-light">Основное фото</label>
                <input type="file" name="image_path" id="image_path" class="form-control bg-dark text-light" accept="image/*">
                @error('image_path') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                @if ($property->image_path)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $property->image_path) }}" alt="Текущее фото" class="img-thumbnail" style="max-width: 140px; border-radius: 6px;">
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label for="plan_image" class="form-label text-light">План дома</label>
                <input type="file" name="plan_image" id="plan_image" class="form-control bg-dark text-light" accept="image/*">
                @error('plan_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                @php $plan = $property->images()->where('is_plan', true)->first(); @endphp
                @if ($plan)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $plan->image_path) }}" alt="Текущий план" class="img-thumbnail" style="max-width: 140px; border-radius: 6px;">
                    </div>
                @endif
            </div>

            <div class="col-12">
                <label class="form-label text-light d-block">Дополнительные фото</label>

                @php $additional = $property->images()->where('is_plan', false)->get(); @endphp
                @if ($additional->count() > 0)
                    <div class="row g-3">
                        @foreach($additional as $image)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Доп. фото" class="img-thumbnail mb-2" style="width: 120px; height: 120px; object-fit: cover; border-radius: 6px;">
                                <div class="form-check d-inline-flex align-items-center gap-2">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="del_{{ $image->id }}" class="form-check-input">
                                    <label for="del_{{ $image->id }}" class="form-check-label text-light small">Удалить</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Пока нет дополнительных фото.</p>
                @endif

                <div class="mt-3">
                    <label for="additional_images" class="form-label text-light">Загрузить новые (до 5 всего)</label>
                    <input type="file" name="additional_images[]" id="additional_images" class="form-control bg-dark text-light" multiple accept="image/*">
                    @error('additional_images.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary dashboard-btn-primary">Обновить объект</button>
            <a href="{{ route('dashboard.properties.index') }}" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection