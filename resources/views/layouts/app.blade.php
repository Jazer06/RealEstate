<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RealEstate') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Infant:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/body.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>
@include('profile.settings-modal', ['user' => auth()->user()])
<body>
    <nav class="navbar navbar-light" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <div class="d-flex align-items-center">
                <a href="tel:+1234567890" class="nav-link phone-icon me-3">
                    <i class="bi bi-telephone-fill"></i>
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
        </div>
        <div class="container">
            <ul class="nav justify-content-center fs-6">
                <li class="nav-item dropdown">
                    <a class="nav-link fs-14 dropdown-toggle" href="#" role="button" id="propertiesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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

    <footer class="bg-dark text-white text-center py-3 mt-4">
        <div class="container">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Все права защищены.</p>
            <p>
                <a href="#" class="text-white">О нас</a> |
                <a href="#" class="text-white">Контакты</a> |
                <a href="#" class="text-white">Политика конфиденциальности</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdowns = document.querySelectorAll('.nav-item.dropdown');
            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                dropdown.addEventListener('mouseenter', () => {
                    toggle.classList.add('show');
                    dropdown.querySelector('.dropdown-menu').classList.add('show');
                });
                dropdown.addEventListener('mouseleave', () => {
                    toggle.classList.remove('show');
                    dropdown.querySelector('.dropdown-menu').classList.remove('show');
                });
            });

            const navbar = document.getElementById('mainNavbar');
            if (navbar) {
                window.addEventListener('scroll', function () {
                    if (window.scrollY > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                });
            }
        });

        let lastScrollTop = 0;
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('mainNavbar');
            if (!navbar) return;
            const currentScrollTop = window.scrollY || document.documentElement.scrollTop;
            if (currentScrollTop > lastScrollTop && currentScrollTop > 50) {
                navbar.classList.add('hidden');
            } else {
                navbar.classList.remove('hidden');
            }
            lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
        });
    </script>
</body>
</html>