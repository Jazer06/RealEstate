<nav class="navbar navbar-light" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Sofiarealty</a>
        <div class="d-flex align-items-center gap-2">
            <a href="tel:{{ $phoneNumber ?? '+1234567890' }}" class="nav-link d-flex align-items-center">
                <i class="bi bi-telephone-fill text-dark" style="font-size: 1.1rem;"></i>
                <span class="d-none d-md-inline ms-1" style="white-space: nowrap;">
                    {{ $phoneNumber ?? '+7 (953) 555-33-32' }}
                </span>
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
        <ul class="nav justify-content-start fs-6 mt-2 w-100 border-to fw-bold">
            <li class="nav-item">
                <a class="nav-link fs-14" href="{{ route('properties.index') }}">
                    Объекты недвижимости
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle fs-14" href="#" role="button" id="servicesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Услуги
                </a>
                <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                    <li>
                        <a class="dropdown-item fs-12" href="{{ route('consultation') }}">Консультация</a>
                    </li>
                    <li>
                        <a class="dropdown-item fs-12" href="{{ route('services.real_estate') }}">Покупка недвижимости</a>
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