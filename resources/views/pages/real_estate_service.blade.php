@extends('layouts.app')

@section('title', 'Услуга: Покупка недвижимости')

@section('content')

<div class="row justify-content-center text-center mt-6">
    <div class="col-md-10 col-lg-8">
        <h1 class="display-4 font-weight-bold mb-3">Покупка недвижимости с профессионалами</h1>
        <p class="lead text-muted">Мы сделаем процесс покупки недвижимости простым и надежным — от подбора идеального объекта до подписания договора.</p>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-consult">
            <div class="card-consult-body text-center">
                <div class="mb-3">
                    <img src="{{ asset('storage/images/home_heart.webp') }}"
                         alt="Покупка недвижимости"
                         class="img-fluid"
                         style="width: 180px; height: auto; max-width: 100%; object-fit: contain;">
                </div>

                <h2 class="mb-3">Полное сопровождение сделки</h2>
                <p class="text-muted mb-4">Наши эксперты помогут вам на каждом этапе покупки недвижимости, обеспечивая комфорт и уверенность.</p>
                <ul class="text-start list-unstyled">
                    <li><i class="bi bi-check-circle-fill text-dark-feol me-2"></i>Поиск объектов по вашим критериям</li>
                    <li><i class="bi bi-check-circle-fill text-dark-feol me-2"></i>Организация просмотров</li>
                    <li><i class="bi bi-check-circle-fill text-dark-feol me-2"></i>Проверка юридической чистоты</li>
                    <li><i class="bi bi-check-circle-fill text-dark-feol me-2"></i>Оформление ипотеки</li>
                    <li><i class="bi bi-check-circle-fill text-dark-feol me-2"></i>Сопровождение при сделке</li>
                </ul>
                <a href="{{ route('contacts') }}" class="iphone-button-black mt-4 mb-5">Заказать услугу</a>
            </div>
        </div>
    </div>
</div>
@endsection