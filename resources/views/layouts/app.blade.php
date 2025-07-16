<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RealEstate') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            @if (Auth::user()->avatar)
                                <a class="nav-link" href="{{ route('profile') }}">
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                </a>
                            @else
                                <a class="nav-link" href="{{ route('profile') }}">
                                    <span class="rounded-circle" style="width: 40px; height: 40px; background: #ccc; display: inline-flex; align-items: center; justify-content: center; color: white;">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </a>
                            @endif
                        </li>
                        @if (Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Админка</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.properties.index') }}">Объекты</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link">Выйти</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    <!-- Добавляем дефолтный подвал -->
    <footer class="bg-dark text-white text-center py-3 mt-4">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Все права защищены.</p>
            <p>
                <a href="#" class="text-white">О нас</a> |
                <a href="#" class="text-white">Контакты</a> |
                <a href="#" class="text-white">Политика конфиденциальности</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>