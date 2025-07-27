@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container py-4 mt-6">
    <h1 class="text-3xl font-bold mb-4">Админ-панель</h1>
    <p class="mb-4">Добро пожаловать, {{ Auth::user()->name }}!</p>

    <!-- Навигация вкладок -->
    <ul class="nav nav-tabs mb-4 dashboard-nav-tabs" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Главная страница</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects" type="button" role="tab" aria-controls="projects" aria-selected="false">Проекты</button>
        </li>
    </ul>

    <!-- Контент вкладок -->
    <div class="tab-content dashboard-tab-content" id="adminTabsContent">
        <!-- Вкладка Главная страница -->
        <div class="tab-pane fade show active p-4" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h5 class="card-title text-xl font-semibold mb-3">Управление главной страницей</h5>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 dashboard-alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a href="{{ route('dashboard.sliders.create') }}" class="btn btn-primary dashboard-btn-primary mb-3">Добавить слайд</a>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Название</th>
                            <th scope="col">Заголовок</th>
                            <th scope="col">Подпись</th>
                            <th scope="col">Текст кнопки</th>
                            <th scope="col">Ссылка</th>
                            <th scope="col">Изображение</th>
                            <th scope="col">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sliders as $slider)
                            <tr class="align-middle">
                                <td>Sлайд {{ $loop->index + 1 }}</td>
                                <td>{{ $slider->title ?: '-' }}</td>
                                <td>{{ $slider->subtitle ?: '-' }}</td>
                                <td>{{ $slider->button_text ?: '-' }}</td>
                                <td>{{ $slider->button_link ?: '-' }}</td>
                                <td>
                                    @if ($slider->image_path)
                                        <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Нет изображения</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dashboard.sliders.edit', $slider) }}" class="btn btn-warning btn-sm text-white hover:bg-yellow-600">Редактировать</a>
                                        <form action="{{ route('dashboard.sliders.destroy', $slider) }}" method="POST" style="display:inline;" onsubmit="return confirm('Вы уверены?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm text-white hover:bg-red-600">Удалить</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">Слайдеров нет. Добавьте новый!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Вложенные вкладки внутри Главная страница -->
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active p-3" style="background-color: #444; border-radius: 8px;" id="home-main" role="tabpanel" aria-labelledby="home-main-tab">
                    <p>Здесь основной контент главной страницы (например, настройки баннеров или текста).</p>
                </div>
                <div class="tab-pane fade p-3" style="background-color: #444; border-radius: 8px;" id="home-test" role="tabpanel" aria-labelledby="home-test-tab">
                    <h6 class="text-lg font-semibold mb-2">Тестовая секция</h6>
                    <p>Это тестовый раздел для будущих функций. Пока в разработке.</p>
                    <a href="#" class="btn btn-primary dashboard-btn-primary mt-2">Добавить что-то</a>
                </div>
            </div>
        </div>

        <!-- Вкладка Проекты -->
        <div class="tab-pane fade p-4" id="projects" role="tabpanel" aria-labelledby="projects-tab">
            <h5 class="card-title text-xl font-semibold mb-3">Управление проектами</h5>
            <p class="mb-4">Здесь будет список проектов. Пока в разработке.</p>
            <a href="#" class="btn btn-primary dashboard-btn-primary">Добавить проект</a>
        </div>
    </div>
</div>
@endsection