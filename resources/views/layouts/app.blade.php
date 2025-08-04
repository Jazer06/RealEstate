<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Продажа квартир в Дагестане: Махачкала, Каспийск, Дербент. Купите жилье от застройщика недорого!">
    <meta name="keywords" content="купить квартиру в Дагестане, недвижимость Махачкала, новостройки Каспийск, квартиры Дербент, жилье в Дагестане">
    <meta name="author" content="Sofiarealty">
    <title>{{ config('app.name', 'Sofiarealty') }} | Купить квартиру в Дагестане</title>

    <!-- Подключение CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/body.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Модальное окно настроек профиля -->
    @include('profile.settings-modal', ['user' => auth()->user()])

</head>
<body>
    @include('layouts.header')
    @yield('carousel')
        <div class="container mt-6">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </div>

    @include('layouts.footer')
    <a href="tel:{{ $phoneNumber ?? '+79535553332' }}"
       class="btn-float-phone phone-bounce"
       aria-label="Позвонить">
        <i class="bi bi-telephone-fill"></i>
    </a>
    <button id="backToTop" class="btn-float-up" aria-label="Наверх">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <script>
        window.appConfig = {
            minPrice: {{ isset($minPrice) ? $minPrice : 0 }},
            maxPrice: {{ isset($maxPrice) ? $maxPrice : 100000000 }}
        };
    </script>

    <!-- Подключение скриптов -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/nouislider.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    @yield('scripts')
</body>
</html>