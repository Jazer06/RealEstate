<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RealEstate') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Preconnect для Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Infant:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">

    <!-- Ваши CSS -->
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/body.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    <!-- Модальное окно настроек профиля вставлено в head, что нестандартно, но допустимо -->
    @include('profile.settings-modal', ['user' => auth()->user()])
</head>

<body>
    <nav class="navbar navbar-light" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <div class="d-flex align-items-center">
                <a href="tel:+1234567890" class="nav-link phone-icon me-3">
                        +7(953)-555-33-32
                </a>
                @auth
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <span class="rounded-circle" style="width: 40px; height: 40px; background: #ccc; display: inline-flex; align-items: center; justify-content: center; color: white;">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">В профиль</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileSettingsModal">Настройки профиля</a></li>
                        @if (Auth::user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Админка</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.properties.index') }}">Объекты</a></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item">Выход</button>
                            </form>
                        </li>
                    </ul>
                </div>
                    @if (Auth::user()->isAdmin())
                        <a class="nav-link ms-3" href="{{ route('dashboard') }}">Админка</a>
                        <a class="nav-link ms-3" href="{{ route('dashboard.properties.index') }}">Объекты</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="ms-3" style="display:inline;">
                        @csrf
                    </form>
                @else
                    <a class="nav-link ms-3" href="{{ route('login') }}" title="Вход или регистрация">
                        <i class="bi bi-person-fill" style="font-size: 1.5rem;"></i>
                    </a>
                @endauth
                <button class="navbar-toggler ms-3" type="button" data-bs-toggle="modal" data-bs-target="#menuModal">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <!-- Нижнее меню внутри того же container -->
            <ul class="nav justify-content-start fs-6 mt-2 w-100">
                <li class="nav-item dropdown">
                    <a class="nav-link fs-14 dropdown-toggle" href="#" role="button" id="propertiesDropdown" data-bs-toggle="dropdown" aria-expanded="false">3
                        Объекты
                    </a>
                    <ul class="dropdown-menu dropdown-menu-large" aria-labelledby="propertiesDropdown">
                        <li><a class="dropdown-item fs-12" href="">Все объекты</a></li>
                        <li><a class="dropdown-item fs-12" href="">Добавить объект</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fs-14" href="#" role="button" id="servicesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Услуги
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                        <li><a class="dropdown-item fs-12" href="#">Консультация</a></li>
                        <li><a class="dropdown-item fs-12" href="#">Оценка</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="">Контакты</a>
                </li>
            </ul>
        </div>
    </nav>

    <nav class="main-menu"></nav>

    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="menuModalLabel">Меню</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @guest
                            <li class="list-group-item">Вход или регистрация</li>
                        @endguest
                        @auth
                            <li class="list-group-item">
                                <a href="{{ route('profile') }}" class="text-decoration-none">Профиль</a>
                            </li>
                            @if (Auth::user()->isAdmin())
                                <li class="list-group-item">
                                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Админка</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="{{ route('dashboard.properties.index') }}" class="text-decoration-none">Объекты</a>
                                </li>
                            @endif
                            <li class="list-group-item">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-decoration-none">Выйти</button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Карусель вне контейнера -->
    @yield('carousel')

    <div class="container mt-6">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    <footer class="text-white text-center py-3 mt-4">
        <div class="container">
            <div class="row">
                <!-- Колонка 1: Адрес -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="text-white">Контактная информация</h5>
                    <p class="mb-0">
                        123112, Москва)
                    </p>
                </div>

                <!-- Колонка 2: Политика конфиденциальности -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="text-white">Полезные ссылки</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Политика обработки персональных данных</a></li>
                        <li><a href="#" class="text-white">Третьи лица</a></li>
                    </ul>
                </div>

                <!-- Колонка 3: Контакты -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="text-white">Центр клиентской поддержки</h5>
                    <p class="mb-0">
                        <i class="bi bi-telephone-fill me-1"></i> +7 (495) 514-11-11<br>
                        <i class="bi bi-envelope-fill me-1"></i>group.ru
                    </p>
                </div>
            </div>

            <!-- Соцсети -->
            <div class="d-flex justify-content-center mt-3">
                <a href="#" class="text-white me-2"><i class="bi bi-vk"></i></a>
                <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>
            </div>

            <!-- Авторские права -->
            <div class="mt-3">
                <p class="mb-0">
                    © Group {{ date('Y') }}. Все права защищены.
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- Подключаем jQuery и Slick JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <!-- Инициализация карусели -->
<script>
$(document).ready(function() {
    console.log('jQuery loaded:', typeof $ !== 'undefined');
    console.log('Slick loaded:', typeof $.fn.slick !== 'undefined');

    // Инициализация основного слайдера
    $('.carousel-inner').slick({
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false,
        dots: false,
        fade: true,
        speed: 800,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });

    // Инициализация миниатюр (правки здесь!)
    $('.custom-thumbs-container').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.carousel-inner',
        focusOnSelect: true,
        arrows: false,
        infinite: false,         // ❌ Не нужно бесконечное прокручивание
        centerMode: false,       // ❌ Центрирование ломает верстку
        variableWidth: false,    // ❌ Он добавляет инлайн стили и ширину 100%
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    // Клик по миниатюре — переход к слайду
    $('.thumb-item').on('click', function(e) {
        e.preventDefault();
        var index = $(this).data('slide-index');
        $('.carousel-inner').slick('slickGoTo', index);
    });

    // Обновление активной миниатюры
    $('.carousel-inner').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $('.thumb-item').removeClass('active');
        $('.thumb-item').eq(nextSlide).addClass('active');
    });

    // Переключение по клику на основной слайд
    $('.carousel-inner .carousel-slide').on('click', function(e) {
        if (!$(e.target).closest('.custom-thumbs-container').length) {
            $('.carousel-inner').slick('slickNext');
        }
    });
});
    // Навигация с помощью боковых кнопок
    $('.carousel-nav-btn.up').on('click', function() {
        $('.carousel-inner').slick('slickPrev');
    });

    $('.carousel-nav-btn.down').on('click', function() {
        $('.carousel-inner').slick('slickNext');
    });

</script>

</body>
</html>