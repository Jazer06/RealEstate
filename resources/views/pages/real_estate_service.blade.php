<!-- resources/views/pages/real_estate_service.blade.php -->
@extends('layouts.app')

@section('title', 'Услуга: Покупка недвижимости')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2>Помощь в покупке недвижимости</h2>
                    <p class="lead">Полное сопровождение сделки — от подбора до регистрации.</p>
                    <ul class="text-start">
                        <li>Поиск объектов по вашим критериям</li>
                        <li>Организация просмотров</li>
                        <li>Проверка юридической чистоты</li>
                        <li>Оформление ипотеки</li>
                        <li>Сопровождение при сделке</li>
                    </ul>
                    <a href="{{ route('contacts') }}" class="btn btn-success">Заказать услугу</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection