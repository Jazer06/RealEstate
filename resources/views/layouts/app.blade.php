<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Продажа квартир в Дагестане: Махачкала, Каспийск, Дербент. Купите жилье от застройщика недорого!">
    <meta name="keywords" content="купить квартиру в Дагестане, недвижимость Махачкала, новостройки Каспийск, квартиры Дербент, жилье в Дагестане">
    <meta name="author" content="Sofiarealty">
    <title>{{ config('app.name', 'Sofiarealty') }} | Купить квартиру в Дагестане</title>

    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

    <!-- Твой остальной CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/body.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/show-card.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body>
    @include('layouts.header')
    @yield('carousel')
    <div class="container mt-6">
        @yield('content')
    </div>
    @include('layouts.footer')
    @auth
        @include('profile.settings-modal', ['user' => auth()->user()])
    @endauth

    <a href="tel:{{ config('header_phone_number', '+7(989)657-02-71') }}" class="btn-float-phone phone-bounce" aria-label="Позвонить">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('js/nouislider.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/show-card.js') }}"></script>
    @yield('scripts')
</body>
</html>