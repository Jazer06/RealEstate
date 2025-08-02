@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="container mt-6">
   <div class="dashboard-container py-4 mt-6">
    <h1 class="text-3xl font-bold mb-4">Админ-панель</h1>
    <p class="mb-4">Добро пожаловать, {{ Auth::user()->name }}!</p>

    <!-- Навигация вкладок -->
    <ul class="nav nav-tabs mb-4 dashboard-nav-tabs" id="adminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Главная страница</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="properties-tab" data-bs-toggle="tab" data-bs-target="#properties" type="button" role="tab" aria-controls="properties" aria-selected="false">Объекты</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab" aria-controls="contacts" aria-selected="false">Заявки</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="telephone-tab" data-bs-toggle="tab" data-bs-target="#telephone" type="button" role="tab" aria-controls="telephone" aria-selected="false">Телефон</button>

        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab" aria-controls="email" aria-selected="false">Email</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="banner-tab" data-bs-toggle="tab" data-bs-target="#banner" type="button" role="tab" aria-controls="banner" aria-selected="false">Баннер</button>
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

            @if (isset($createSlider))
                <h6 class="text-lg font-semibold mb-2">Добавить новый слайд</h6>
                <form method="POST" action="{{ route('dashboard.sliders.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Подпись</label>
                        <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle') }}">
                        @error('subtitle') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="button_text" class="form-label">Текст кнопки</label>
                        <input type="text" name="button_text" id="button_text" class="form-control" value="{{ old('button_text') }}">
                        @error('button_text') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="button_link" class="form-label">Ссылка кнопки</label>
                        <input type="text" name="button_link" id="button_link" class="form-control" value="{{ old('button_link') }}">
                        @error('button_link') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Изображение</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary dashboard-btn-primary">Создать</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Отмена</a>
                </form>
            @elseif (isset($editSlider) && isset($slider))
                <h6 class="text-lg font-semibold mb-2">Редактировать слайд</h6>
                <form method="POST" action="{{ route('dashboard.sliders.update', $slider) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $slider->title) }}">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Подпись</label>
                        <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle) }}">
                        @error('subtitle') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="button_text" class="form-label">Текст кнопки</label>
                        <input type="text" name="button_text" id="button_text" class="form-control" value="{{ old('button_text', $slider->button_text) }}">
                        @error('button_text') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="button_link" class="form-label">Ссылка кнопки</label>
                        <input type="text" name="button_link" id="button_link" class="form-control" value="{{ old('button_link', $slider->button_link) }}">
                        @error('button_link') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Изображение</label>
                        @if ($slider->image_path)
                            <img src="{{ asset('storage/' . $slider->image_path) }}" alt="Текущее изображение" class="img-thumbnail mb-2" style="max-width: 200px;">
                        @endif
                        <input type="file" name="image" id="image" class="form-control">
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary dashboard-btn-primary">Обновить</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Отмена</a>
                </form>
            @else
                <a href="{{ route('dashboard.sliders.create') }}" class="btn btn-primary mb-3">Добавить слайд</a>
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
                                    <td>Слайд {{ $loop->index + 1 }}</td>
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

                <!-- Пагинация для слайдеров -->
                <div class="pagination-container">
                    @if ($sliders->hasPages())
                        {{ $sliders->links('pagination::bootstrap-5') }}
                    @else
                    @endif
                </div>
            @endif

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

        <!-- Вкладка Объекты -->
        <div class="tab-pane fade p-4" id="properties" role="tabpanel" aria-labelledby="properties-tab">
            <h5 class="card-title text-xl font-semibold mb-3">Управление объектами недвижимости</h5>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 dashboard-alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a href="{{ route('dashboard.properties.create') }}" class="btn btn-primary mb-3">Добавить объект</a>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Название</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Изображение</th>
                            <th scope="col">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($properties as $property)
                            <tr class="align-middle">
                                <td>{{ $property->title ?: '-' }}</td>
                                <td>{{ $property->address ?: '-' }}</td>
                                <td>{{ number_format($property->price, 0, ',', ' ') }} ₽</td>
                                <td>
                                    @if ($property->image_path)
                                        <img src="{{ asset('storage/' . $property->image_path) }}" alt="{{ $property->title }}" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Нет изображения</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('dashboard.properties.edit', $property) }}" class="btn btn-warning btn-sm text-white hover:bg-yellow-600">Редактировать</a>
                                        <form action="{{ route('dashboard.properties.destroy', $property) }}" method="POST" style="display:inline;" onsubmit="return confirm('Вы уверены?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm text-white hover:bg-red-600">Удалить</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Объектов нет. Добавьте новый!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Пагинация для объектов -->
            <div class="pagination-container">
                @if ($properties->hasPages())
                    {{ $properties->links('pagination::bootstrap-5') }}
                @else
                @endif
            </div>
        </div>

        <!-- Вкладка Заявки -->
        <div class="tab-pane fade p-4" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
            <h5 class="card-title text-xl font-semibold mb-3">Управление заявками</h5>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 dashboard-alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Имя</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contacts as $contact)
                            <tr class="align-middle">
                                <td>{{ $contact->name ?: '-' }}</td>
                                <td>{{ $contact->phone ?: '-' }}</td>
                                <td>{{ $contact->description ?: '-' }}</td>
                                <td>{{ $contact->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('dashboard.contacts.destroy', $contact) }}" method="POST" style="display:inline;" onsubmit="return confirm('Удалить заявку?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm text-white hover:bg-red-600">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Заявок нет.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Добавление пагинации -->
                <div class="pagination-container">
                    @if ($contacts->hasPages())
                        {{ $contacts->links('pagination::bootstrap-5') }}
                    @else
                    @endif
                </div>
            </div>
        </div>
        <!-- Вкладка Телефон -->
        <div class="tab-pane fade p-4" id="telephone" role="tabpanel" aria-labelledby="telephone-tab">
            <h5 class="card-title text-xl font-semibold mb-3">Смена телефона на сайте</h5>
            <p>При клике на поле показывается старый.</p>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 dashboard-alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="POST" action="{{ route('dashboard.phone.update') }}" class="mb-4">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Номер телефона</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $phoneNumber ?? '+7 (953) 555-33-32') }}" placeholder="+7(XXX)-XXX-XX-XX">
                    @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary dashboard-btn-primary">Сохранить телефон</button>
            </form>
        </div>


        <!-- Вкладка Email -->
        <div class="tab-pane fade p-4" id="email" role="tabpanel" aria-labelledby="email-tab">
            <h5 class="card-title text-xl font-semibold mb-3">Смена почты на сайте</h5>
            <p>При клике на поле показывается старая почта.</p>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 dashboard-alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="POST" action="{{ route('dashboard.email.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="email" class="form-label">Электронная почта</label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $email ?? 'group.ru') }}" placeholder="example@email.com">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary dashboard-btn-primary">Сохранить почту</button>
            </form>
        </div>

        <div class="tab-pane fade p-4" id="banner" role="tabpanel" aria-labelledby="banner-tab">
            <h5 class="card-title text-xl font-semibold mb-3">Текст баннера на главной</h5>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('dashboard.banner.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="banner_title" class="form-label">Заголовок</label>
                    <input type="text" name="banner_title" id="banner_title" class="form-control" 
                           value="{{ old('banner_title', \App\Models\Setting::where('key', 'banner_title')->value('value')) }}">
                    @error('banner_title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="banner_description" class="form-label">Описание</label>
                    <textarea name="banner_description" id="banner_description" rows="4" class="form-control">{{ old('banner_description', \App\Models\Setting::where('key', 'banner_description')->value('value')) }}</textarea>
                    @error('banner_description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>


    </div> <!-- Закрытие tab-content -->
</div> <!-- Закрытие dashboard-container -->
</div>
<style>
    input.form-control,
textarea.form-control,
select.form-control {
    background-color: #fff !important;
    color: #000 !important;
    border: 1px solid #ccc;
}

input.form-control:focus,
textarea.form-control:focus,
select.form-control:focus {
    background-color: #fff !important;
    color: #000 !important;
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

</style>