@extends('layouts.app')

@section('title', 'Бесплатная консультация по недвижимости в Дагестане')

@section('meta')
    <meta name="description" content="Получите бесплатную консультацию по недвижимости в Махачкале, Каспийске, Дербенте. Подбор квартир, помощь с ипотекой, юридическая проверка сделок.">
    <meta name="keywords" content="консультация по недвижимости Дагестан, купить квартиру Махачкала, ипотека Каспийск, юридическая проверка Дербент">
@endsection

@section('content')
<div class="container my-5 mt-6">
    <div class="row justify-content-center text-center mb-5 mt-6">
        <div class="col-md-10 col-lg-8">
            <h1 class="display-4 font-weight-bold mb-3">Консультация по недвижимости в Дагестане</h1>
            <p class="lead text-muted">
                Получите профессиональную помощь от наших экспертов! Мы подберем идеальный объект под ваш бюджет, поможем с оформлением ипотеки и проверим юридическую чистоту сделки.
            </p>
        </div>
    </div>

    <!-- Преимущества консультации -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-4 mb-4">
            <div class="card-consult shadow-sm h-100">
                <div class="card-consult-body text-center">
                    <i class="bi bi-house-door-fill text-feoil" style="font-size: 2.5rem;"></i>
                    <h5 class="card-consult-title mt-3">Подбор недвижимости</h5>
                    <p class="card-consult-text">Найдем объект, который идеально соответствует вашим пожеланиям и бюджету.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card-consult shadow-sm h-100">
                <div class="card-consult-body text-center">
                    <i class="bi bi-bank text-feoil" style="font-size: 2.5rem;"></i>
                    <h5 class="card-consult-title mt-3">Помощь с ипотекой</h5>
                    <p class="card-consult-text">Подберем лучшие ипотечные программы и поможем с оформлением документов.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card-consult shadow-sm h-100">
                <div class="card-consult-body text-center">
                    <i class="bi bi-shield-check text-feoil" style="font-size: 2.5rem;"></i>
                    <h5 class="card-consult-title mt-3">Юридическая проверка</h5>
                    <p class="card-consult-text">Гарантируем чистоту сделки с полной проверкой документов.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Форма обратной связи -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="shadow-sm" style="border-radius: 12px;">
                <div class="card-consult-body">
                    <h3 class="text-center mb-4">Запишитесь на бесплатную консультацию</h3>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('contact.store') }}" enctype="multipart/form-data" id="consultation-form">
                        @csrf
                        <div class="mb-3">
                            <label for="consultation-name" class="form-label">Ваше Имя</label>
                            <input type="text" name="name" id="consultation-name" class="form-control @error('name') is-invalid @enderror" maxlength="20" pattern="[а-яА-ЯёЁa-zA-Z\s\-]+" required value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="consultation-phone" class="form-label">Ваш Телефон</label>
                            <input type="tel" name="phone" id="consultation-phone" class="form-control @error('phone') is-invalid @enderror" maxlength="18" placeholder="+7 (xxx) xxx-xx-xx" value="{{ old('phone') ?: '+7' }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description_type" class="form-label">Причина обращения</label>
                            <select name="description_type" id="description_type" class="form-select mb-2" onchange="document.getElementById('description').value = this.value">
                                <option value="">Выберите тип</option>
                                <option value="Покупка недвижимости">Покупка недвижимости</option>
                                <option value="Консультация">Консультация</option>
                                <option value="Другое">Другое</option>
                            </select>
                            <label for="description" class="form-label">Описание</label>
                            <textarea style="resize: none;" name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" maxlength="100" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="iphone-button-black">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Контактная информация -->
    <div class="row justify-content-center text-center mt-5">
        <div class="col-lg-8 col-md-10">
            <h4 class="text-primary-gradient mb-3" style="font-weight: 600; font-size: 1.75rem;">
                Другие способы связи
            </h4>
            <p class="text-muted" style="font-size: 1.1rem; line-height: 1.8;">
                Позвоните нам:
                <a href="tel:{{ \App\Models\Setting::where('key', 'header_phone_number')->value('value') }}"
                   class="text-link hover-effect">
                    {{ \App\Models\Setting::where('key', 'header_phone_number')->value('value') }}
                </a>
                <br>
                Напишите нам:
                <a href="mailto:{{ \App\Models\Setting::where('key', 'header_email')->value('value') }}"
                   class="text-link hover-effect">
                    {{ \App\Models\Setting::where('key', 'header_email')->value('value') }}
                </a>
            </p>
            <div class="contact-icons mt-3">
                <a href="tel:{{ \App\Models\Setting::where('key', 'header_phone_number')->value('value') }}" class="icon-link me-4">
                    <i class="bi bi-telephone-fill"></i>
                </a>
                <a href="mailto:{{ \App\Models\Setting::where('key', 'header_email')->value('value') }}" class="icon-link">
                    <i class="bi bi-envelope-fill"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection