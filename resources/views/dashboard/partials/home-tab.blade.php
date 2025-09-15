<div class="tab-pane fade show  p-4" id="home" role="tabpanel" aria-labelledby="home-tab">
    <h5 class="card-title text-xl font-semibold mb-3 text-light">Управление  ЖК</h5>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 dashboard-alert-success" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (isset($createSlider))
        @include('dashboard.partials.slider-form', [
            'action' => route('dashboard.sliders.store'),
            'method' => 'POST',
            'title' => 'Добавить ЖК',
            'slider' => null
        ])
    @elseif (isset($editSlider) && isset($slider))
        @include('dashboard.partials.slider-form', [
            'action' => route('dashboard.sliders.update', $slider),
            'method' => 'PUT',
            'title' => 'Редактировать ЖК',
            'slider' => $slider
        ])
    @else
        <a href="{{ route('dashboard.sliders.create') }}" class="btn btn-primary mb-3">Добавить ЖК</a>
        @include('dashboard.partials.slider-table', ['sliders' => $sliders])
    @endif
</div>