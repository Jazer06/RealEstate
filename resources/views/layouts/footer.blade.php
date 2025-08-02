<footer class="footer text-center py-4 mt-9">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4 text-center">
                <img src="{{ asset('storage/logo/logo.webp') }}" alt="{{ config('app.name') }} Logo" class="footer-logo">
                <p class="footer-mission mt-2">Мы помогаем найти ваш идеальный дом!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="footer-title">Навигация</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">Главная</a></li>
                    <li><a href="{{ route('consultation') }}">Консультация</a></li>
                    <li><a href="{{ route('services.real_estate') }}">Услуги</a></li>
                    <li><a href="{{ route('contacts') }}">Контакты</a></li>
                    <li><a href="{{ route('privacy.policy') }}">Политика конфиденциальности</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="footer-title">Контактная информация</h5>
                <p class="mb-2">г. Махачкала, ул. Нурадилова, 99</p>
                <p class="mb-0">
                    <i class="bi bi-telephone-fill me-1"></i> {{ $phoneNumber ?? '+7 (495) 514-11-11' }}<br>
                    <i class="bi bi-envelope-fill me-1"></i> {{ $email ?? 'info@group.ru' }}
                </p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="footer-title">Полезные ссылки</h5>
                <ul class="list-unstyled">
                    @auth
                        <li><a href="{{ route('profile') }}">Избранное</a></li>
                        <li><a href="{{ route('profile') }}">Профиль</a></li>
                    @endauth
                    @guest
                        <li><a href="{{ route('login') }}">Войти</a></li>
                    @endguest
                </ul>
            </div>
        </div>
        <!-- Авторские права -->
        <div class="mt-4">
            <p class="mb-0">© {{ config('app.name') }} {{ date('Y') }}. Все права защищены.</p>
        </div>
    </div>

    <!-- Структурированные данные для SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "url": "{{ route('home') }}",
        "logo": "{{ asset('storage/logo/logo.webp') }}",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Махачкала",
            "addressRegion": "Дагестан",
            "streetAddress": "ул. Нурадилова, 99",
            "postalCode": "367000",
            "addressCountry": "RU"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "{{ $phoneNumber ?? '+7 (495) 514-11-11' }}",
            "email": "{{ $email ?? 'info@group.ru' }}",
            "contactType": "customer service"
        }
    }
    </script>
</footer>