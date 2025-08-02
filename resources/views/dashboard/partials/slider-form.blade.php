<h6 class="text-lg font-semibold mb-2">{{ $title }}</h6>
<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="title" class="form-label">Название</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $slider->title ?? '') }}">
        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label for="subtitle" class="form-label">Подпись</label>
        <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle ?? '') }}">
        @error('subtitle') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label for="button_text" class="form-label">Текст кнопки</label>
        <input type="text" name="button_text" id="button_text" class="form-control" value="{{ old('button_text', $slider->button_text ?? '') }}">
        @error('button_text') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label for="button_link" class="form-label">Ссылка кнопки</label>
        <input type="text" name="button_link" id="button_link" class="form-control" value="{{ old('button_link', $slider->button_link ?? '') }}">
        @error('button_link') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Изображение</label>
        @if ($slider && $slider->image_path)
            <img src="{{ asset('storage/' . $slider->image_path) }}" alt="Текущее изображение" class="img-thumbnail mb-2 dashboard-img-thumbnail">
        @endif
        <input type="file" name="image" id="image" class="form-control">
        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <button type="submit" class="btn btn-primary dashboard-btn-primary">Сохранить</button>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Отмена</a>
</form>