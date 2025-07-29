@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать объект</h1>
    <form method="POST" action="{{ route('dashboard.properties.update', $property->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Название</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $property->title) }}">
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $property->description) }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Цена, ₽</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $property->price) }}">
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Адрес</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $property->address) }}">
            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="area" class="form-label">Площадь, м²</label>
            <input type="number" name="area" id="area" class="form-control" value="{{ old('area', $property->area) }}">
            @error('area') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="rooms" class="form-label">Комнаты</label>
            <input type="number" name="rooms" id="rooms" class="form-control" value="{{ old('rooms', $property->rooms) }}">
            @error('rooms') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Тип</label>
            <select name="type" id="type" class="form-select">
                <option value="">Выберите тип</option>
                <option value="квартира" {{ old('type', $property->type) == 'квартира' ? 'selected' : '' }}>Квартира</option>
                <option value="дом" {{ old('type', $property->type) == 'дом' ? 'selected' : '' }}>Дом</option>
                <option value="коммерческая" {{ old('type', $property->type) == 'коммерческая' ? 'selected' : '' }}>Коммерческая</option>
            </select>
            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="image_path" class="form-label">Основное фото</label>
            @if($property->image_path)
                <img src="{{ asset('storage/' . $property->image_path) }}" alt="Текущее фото" class="img-thumbnail mb-2" style="max-width: 200px;">
            @endif
            <input type="file" name="image_path" id="image_path" class="form-control">
            @error('image_path') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="additional_images" class="form-label">Дополнительные фото</label>
            <div class="row">
                @foreach($property->images as $image)
                    <div class="col-md-3 mb-2">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Дополнительное фото" class="img-thumbnail" style="max-width: 100px;">
                    </div>
                @endforeach
            </div>
            <input type="file" name="additional_images[]" id="additional_images" class="form-control" multiple>
            @error('additional_images.*') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
</div>
@endsection