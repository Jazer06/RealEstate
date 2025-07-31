<!-- resources/views/pages/contacts.blade.php -->
@extends('layouts.app')

@section('title', 'Контакты агентства')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center">Контакты</h2>
                    <p><strong>Телефон:</strong> +7 (XXX) XXX-XX-XX</p>
                    <p><strong>Email:</strong> info@realestate.com</p>
                    <p><strong>Адрес:</strong> г. Москва, ул. Ленина, д. 10</p>
                    <div class="text-center mt-4">
                        <a href="tel:+7XXX" class="btn btn-outline-primary me-3">Позвонить</a>
                        <a href="mailto:info@realestate.com" class="btn btn-outline-secondary">Написать</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection