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
                    <li><a href="{{ route('privacy.policy') }}">Политика обработки персональных данных</a></li>
                    <li><a href="#" class="text-white">Третьи лица</a></li>
                </ul>
            </div>
            <!-- Колонка 3: Контакты -->
            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="text-white">Центр клиентской поддержки</h5>
                <p class="mb-0">
                    <i class="bi bi-telephone-fill me-1"></i> {{ $phoneNumber ?? '+7 (495) 514-11-11' }}<br>
                    <i class="bi bi-envelope-fill me-1"></i> {{ $email ?? 'group.ru' }}
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