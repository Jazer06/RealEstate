<div class="tab-pane fade p-4" id="banner" role="tabpanel" aria-labelledby="banner-tab">
    <h5 class="card-title text-xl font-semibold mb-3">Текст баннера на главной</h5>

    @if(session('success'))
        <div class="dashboard-alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('dashboard.banner.update') }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="banner_title" class="form-label">Заголовок</label>
            <input type="text" name="banner_title" id="banner_title" class="form-control" value="{{ old('banner_title', \App\Models\Setting::where('key', 'banner_title')->value('value')) }}">
            @error('banner_title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="banner_description" class="form-label">Описание</label>
            <textarea name="banner_description" id="banner_description" rows="4" class="form-control">{{ old('banner_description', \App\Models\Setting::where('key', 'banner_description')->value('value')) }}</textarea>
            @error('banner_description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary dashboard-btn-primary">Сохранить</button>
    </form>
</div>
