@extends('layouts.app')

@section('title', 'Контакты агентства недвижимости в Дагестане')

@section('meta')
    <meta name="description" content="Свяжитесь с Sofiarealty для покупки квартир в Махачкале, Каспийске, Дербенте. Получите консультацию по недвижимости!">
    <meta name="keywords" content="контакты агентства недвижимости Дагестан, купить квартиру Махачкала, консультация по недвижимости Каспийск, недвижимость Дербент">
@endsection

@section('content')
<div class="container my-5 mt-6 mb-2">
    <div class="info-card depth-card mt-9" style="background: #fff; border-radius: 12px; border: 1px solid #e9ecef; padding: 25px;box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="card-body">
            <h3 class="card-title" style="color: #333; margin-bottom: 1.5rem; font-weight: 600;">Контактная информация</h3>
            <ul class="list-group list-group-flush" style="border: none;">
                <li class="list-group-item" style="padding: 0.75rem 0; border: none; background: transparent; border-bottom: 1px solid #f0f0f0;">
                    <strong style="color: #495057;">Email:</strong>
                    <span style="color: #6c757d; margin-left: 10px;">{{ $email ?? 'Не указан' }}</span>
                </li>
                <li class="list-group-item" style="padding: 0.75rem 0; border: none; background: transparent; border-bottom: 1px solid #f0f0f0;">
                    <strong style="color: #495057;">Телефон:</strong>
                    <span style="color: #6c757d; margin-left: 10px;">{{ $phoneNumber ?? 'Не указан' }}</span>
                </li>
                <li class="list-group-item" style="padding: 0.75rem 0; border: none; background: transparent;">
                    <strong style="color: #495057;">Адрес:</strong>
                    <span style="color: #6c757d; margin-left: 10px;">г. Махачкала, ул. Нурадилова, 99</span>
                </li>
            </ul>
            <div class="text-center mt-4">
                @if($phoneNumber)
                    <a href="tel:{{ $phoneNumber }}" class="iphone-button-black me-2">Позвонить</a>
                @endif
                <button type="button" class="iphone-button-black" data-bs-toggle="modal" data-bs-target="#contactModal">
                    Написать
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background: #fff; border: 2px solid; border-radius: 12px;">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Обратная связь</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <form method="POST" action="{{ route('contact.store') }}" enctype="multipart/form-data" id="modal-form">
                    @csrf
                    <div class="mb-3">
                        <label for="modal-name" class="form-label">Ваше Имя</label>
                        <input
                            type="text"
                            name="name"
                            id="modal-name"
                            class="form-control @error('name') is-invalid @enderror"
                            maxlength="20"
                            pattern="[а-яА-ЯёЁa-zA-Z\s\-]+"
                            title="Только буквы, пробелы и дефисы"
                            required
                            value="{{ old('name') }}"
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="modal-phone" class="form-label">Ваш Телефон</label>
                        <input
                            type="tel"
                            name="phone"
                            id="modal-phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            maxlength="18"
                            placeholder="+7 (xxx) xxx-xx-xx"
                            value="{{ old('phone') ?: '+7' }}"
                            required
                            autocomplete="off"
                            inputmode="numeric"
                        >
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="modal-description_type" class="form-label">Причина обращения</label>
                        <select
                            name="description_type"
                            id="modal-description_type"
                            class="form-select mb-2"
                            onchange="document.getElementById('modal-description').value = this.value"
                        >
                            <option value="">Выберите тип</option>
                            <option value="Покупка недвижимости">Покупка недвижимости</option>
                            <option value="Консультация">Консультация</option>
                            <option value="Другое">Другое</option>
                        </select>
                        <label for="modal-description" class="form-label">Описание</label>
                        <textarea
                            style="resize: none;"
                            name="description"
                            id="modal-description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="3"
                            maxlength="100"
                            required
                        >{{ old('description') }}</textarea>
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

@section('scripts')
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Sofiarealty",
        "url": "{{ url('/') }}",
        "contactPoint": [
            {
                "@type": "ContactPoint",
                "telephone": "{{ $phoneNumber ?? '+7 (953) 555-33-32' }}",
                "contactType": "customer service",
                "areaServed": "RU",
                "availableLanguage": "Russian"
            },
            {
                "@type": "ContactPoint",
                "email": "{{ $email ?? 'info@sofiarealty.ru' }}",
                "contactType": "customer service"
            }
        ],
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Махачкала",
            "addressCountry": "RU",
            "streetAddress": "ул. Нурадилова, 99"
        }
    }
    </script>
@endsection