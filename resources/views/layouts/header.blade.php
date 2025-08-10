<nav class="navbar navbar-light" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Sofiarealty</a>
            <div class="d-flex align-items-center gap-2">
                <a href="tel:{{ $phoneNumber ?? '+1234567890' }}" class="nav-link d-flex align-items-center phone-icon">
                    <i class="bi bi-telephone-fill text-dark"></i>
                    <span class="d-none d-md-inline fs-6 text-dark">
                        {{ $phoneNumber ?? '+7 (953) 555-33-32' }}
                    </span>
                </a>
                @auth
                    <a class="nav-link me-3 favorite-icon" href="{{ route('profile') }}" title="Избранное">
                        <i class="bi bi-heart"></i>
                    </a>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Auth::check() && Auth::user()->avatar)
                                <img 
                                    src="{{ Storage::url(Auth::user()->avatar) }}" 
                                    alt="{{ Auth::user()->name }}" 
                                    class="rounded-circle" 
                                    style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <span class="rounded-circle" 
                                      style="width: 40px; height: 40px; background: #ccc; display: inline-flex; align-items: center; justify-content: center; color: white;">
                                    {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'Г' }}
                                </span>
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
                @else
                    <a class="nav-link ms-3" href="{{ route('login') }}" title="Вход или регистрация">
                        <i class="bi bi-person-fill" style="font-size: 1.5rem;"></i>
                    </a>
                @endauth
                <button class="navbar-toggler" type="button" data-bs-toggle="modal" data-bs-target="#menuModal">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        <ul class="nav justify-content-start fs-6 mt-2 w-100 border-to fw-bold main-nav-links">
            <li class="nav-item">
                <a class="nav-link fs-14" href="{{ route('properties.index') }}">Объекты недвижимости</a>
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
@php
    $latestProperties = App\Models\Property::latest()->take(5)->get();
@endphp
<div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="menuModalLabel">Меню</h5>
                <button type="button" 
                        class="btn p-0" 
                        style="width: 15px; height: 15px; background: none; border: none;" 
                        data-bs-dismiss="modal" 
                        aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="#dc3545" viewBox="0 0 16 16">
                        <path d="M.293.293a1 1 0 011.414 0L8 6.586l6.293-6.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    @guest
                        <li class="list-group-item">
                            <a href="{{ route('login') }}" class="text-decoration-none text-light">Вход или регистрация</a>
                        </li>
                    @endguest
                    @auth
                        <li class="list-group-item">
                            <a href="{{ route('profile') }}" class="text-decoration-none text-light">Профиль</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('profile') }}" class="text-decoration-none text-light">Избранное</a>
                        </li>
                        @if (Auth::user()->isAdmin())
                            <li class="list-group-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-light">Админка</a>
                            </li>
                        @endif
                        <li class="list-group-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-decoration-none text-light">Выйти</button>
                            </form>
                        </li>
                    @endauth
                    <!-- Пункты навигации -->
                    <li class="list-group-item">
                        <a href="{{ route('properties.index') }}" class="text-decoration-none text-light">Объекты недвижимости</a>
                    </li>
                    <li class="list-group-item">
                        <a class="text-decoration-none dropdown-toggle text-light" href="#" role="button" id="servicesModalDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Услуги
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="servicesModalDropdown">
                            <li>
                                <a class="dropdown-item fs-12" href="{{ route('consultation') }}">Консультация</a>
                            </li>
                            <li>
                                <a class="dropdown-item fs-12" href="{{ route('services.real_estate') }}">Покупка недвижимости</a>
                            </li>
                        </ul>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('contacts') }}" class="text-decoration-none text-light">Контакты</a>
                    </li>
                </ul>
                 @include('components.modal-properties', ['properties' => $latestProperties])
            </div>
            <div class="modal-footer text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mb-3 text-center">
                            <img src="{{ asset('storage/logo/logo.webp') }}" alt="{{ config('app.name') }} Logo" class="footer-logo" style="max-width: 120px;">
                            <p class="footer-mission mt-2 text-light">Мы помогаем найти ваш идеальный дом!</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <h5 class="footer-title text-light">Контактная информация</h5>
                            <p class="mb-2 text-light">г. Махачкала, ул. Нурадилова, 99</p>
                            <p class="mb-0 text-light">
                                <i class="bi bi-telephone-fill me-1 text-light"></i> {{ $phoneNumber ?? '+7 (495) 514-11-11' }}<br>
                                <i class="bi bi-envelope-fill me-1 text-light"></i> {{ $email ?? 'info@group.ru' }}
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <h5 class="footer-title text-light">Полезные ссылки</h5>
                            <ul class="list-unstyled">
                                <li><a href="{{ route('privacy.policy') }}" class="text-light">Политика конфиденциальности</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-3 text-light">
                        <p class="mb-0">© {{ config('app.name') }} {{ date('Y') }}. Все права защищены.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>