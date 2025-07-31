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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css">

    <!-- Ваши CSS -->
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/body.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    <!-- Модальное окно настроек профиля -->
    @include('profile.settings-modal', ['user' => auth()->user()])
</head>

<body>
    <nav class="navbar navbar-light" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Sofiarealty</a>
            <div class="d-flex align-items-center gap-2">
                <a href="tel:+1234567890" class="nav-link">
                    +7(953)-555-33-32
                </a>
                @auth
                    <!-- Кнопка избранного левее аватарки -->
                    <a class="nav-link me-3 favorite-icon" href="{{ route('profile') }}" title="Избранное">
                        <i class="bi bi-heart"></i>
                    </a>
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
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="ms-3" style="display:inline;">
                        @csrf
                    </form>
                @else
                    <a class="nav-link ms-3" href="{{ route('login') }}" title="Вход или регистрация">
                        <i class="bi bi-person-fill" style="font-size: 1.5rem;"></i>
                    </a>
                @endauth
                <button class="navbar-toggler" type="button" data-bs-toggle="modal" data-bs-target="#menuModal">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <!-- Нижнее меню внутри того же container -->
            <ul class="nav justify-content-start fs-6 mt-2 w-100 border-to fw-bold">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fs-14" href="#" role="button" id="servicesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Услуги
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                        <li>
                            <a class="dropdown-item fs-12" href="{{ route('consultation') }}">
                                Консультация
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item fs-12" href="{{ route('services.real_estate') }}">
                                Покупка недвижимости
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-14" href="{{ route('contacts') }}">Контакты</a>
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
                            <li class="list-group-item">
                                <a href="{{ route('profile') }}" class="text-decoration-none">Избранное</a>
                            </li>
                            @if (Auth::user()->isAdmin())
                                <li class="list-group-item">
                                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Админка</a>
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

    <footer class="text-white text-center py-3 mt-9">
        <div class="container">
            <div class="row">
                <!-- Колонка 1: Адрес -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="text-white">Контактная информация</h5>
                    <p class="mb-0">
                        123112, Москва
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
!-- Скрипты -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>

<script>
    $(document).ready(function() {
        console.log('jQuery loaded:', typeof $ !== 'undefined');
        console.log('Slick loaded:', typeof $.fn.slick !== 'undefined');
        console.log('noUiSlider loaded:', typeof noUiSlider !== 'undefined');

        // Initialize main carousel first
        const $mainCarousel = $('.carousel-inner').slick({
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            dots: false,
            fade: true,
            speed: 800,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            asNavFor: '.custom-thumbs-container'
        });

        // Initialize thumbnail carousel after main carousel
        const $thumbCarousel = $('.custom-thumbs-container').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.carousel-inner',
            focusOnSelect: true,
            arrows: false,
            infinite: false,
            centerMode: false,
            variableWidth: false,
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

        // Handle thumbnail clicks
        $('.thumb-item').on('click', function(e) {
            e.preventDefault();
            const index = $(this).data('slide-index');
            $mainCarousel.slick('slickGoTo', index);
        });

        // Update active thumbnail on main carousel change
        $mainCarousel.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
            console.log('Switching to slide:', nextSlide);
            $('.thumb-item').removeClass('active');
            $('.thumb-item').eq(nextSlide).addClass('active');
            $thumbCarousel.slick('slickGoTo', nextSlide);
        });

        // Handle navigation buttons
        $('.carousel-nav-btn.up').on('click', function() {
            $mainCarousel.slick('slickPrev');
        });

        $('.carousel-nav-btn.down').on('click', function() {
            $mainCarousel.slick('slickNext');
        });

        // Optional: Handle click on main slide to go to next
        $('.carousel-inner .carousel-slide').on('click', function(e) {
            if (!$(e.target).closest('.custom-thumbs-container').length) {
                $mainCarousel.slick('slickNext');
            }
        });

        // =============== ТВОЙ СКРИПТ С ФИЛЬТРАМИ (внутри $(document).ready) ===============
        // Цена
        const priceSlider = document.getElementById('price-range-slider');
        const priceMinInput = document.getElementById('price-range-min');
        const priceMaxInput = document.getElementById('price-range-max');
        const priceMinValue = document.getElementById('price-min-value');
        const priceMaxValue = document.getElementById('price-max-value');
        const minPrice = {{ isset($minPrice) ? $minPrice : 0 }};
        const maxPrice = {{ isset($maxPrice) ? $maxPrice : 100000000 }};

        if (priceSlider && priceMinInput && priceMaxInput && priceMinValue && priceMaxValue) {
            noUiSlider.create(priceSlider, {
                start: [
                    parseFloat(priceMinInput.value) || minPrice,
                    parseFloat(priceMaxInput.value) || maxPrice
                ],
                connect: true,
                range: { min: minPrice, max: maxPrice },
                step: 10000,
                format: {
                    to: value => Math.round(value),
                    from: value => Number(value)
                }
            });

            priceSlider.noUiSlider.on('update', (values, handle) => {
                if (handle === 0) {
                    priceMinInput.value = values[0];
                    priceMinValue.textContent = '₽' + number_format(values[0]);
                } else {
                    priceMaxInput.value = values[1];
                    priceMaxValue.textContent = '₽' + number_format(values[1]);
                }
            });
        }

        // Площадь
        const areaSlider = document.getElementById('area-range-slider');
        const areaMinInput = document.getElementById('area-range-min');
        const areaMaxInput = document.getElementById('area-range-max');
        const areaMinValue = document.getElementById('area-min-value');
        const areaMaxValue = document.getElementById('area-max-value');

        if (areaSlider && areaMinInput && areaMaxInput && areaMinValue && areaMaxValue) {
            noUiSlider.create(areaSlider, {
                start: [
                    parseInt(areaMinInput.value) || 20,
                    parseInt(areaMaxInput.value) || 200
                ],
                connect: true,
                range: { min: 10, max: 500 },
                step: 1
            });

            areaSlider.noUiSlider.on('update', (values, handle) => {
                if (handle === 0) {
                    areaMinInput.value = Math.round(values[0]);
                    areaMinValue.textContent = Math.round(values[0]);
                } else {
                    areaMaxInput.value = Math.round(values[1]);
                    areaMaxValue.textContent = Math.round(values[1]);
                }
            });
        }

        // Сброс фильтров
        document.getElementById('resetFilters')?.addEventListener('click', () => {
            if (priceSlider && priceSlider.noUiSlider) {
                priceSlider.noUiSlider.set([minPrice, maxPrice]);
            }
            if (areaSlider && areaSlider.noUiSlider) {
                areaSlider.noUiSlider.set([20, 200]);
            }
            document.querySelectorAll('input[name="rooms"]').forEach(r => r.checked = false);
            if (document.getElementById('type')) {
                document.getElementById('type').value = '';
            }
            if (document.getElementById('filterForm')) {
                document.getElementById('filterForm').submit();
            }
        });

        function number_format(number, decimals = 0) {
            return parseFloat(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        }
        // =============== КОНЕЦ ФИЛЬТРОВ ===============
    });
</script>

@yield('scripts')
</body>
</html>