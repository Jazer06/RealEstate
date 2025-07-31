<!-- resources/views/pages/consultation.blade.php -->
@extends('layouts.app')

@section('title', 'Консультация по недвижимости')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2>Консультация по недвижимости</h2>
                    <p class="lead">Получите бесплатную консультацию от наших экспертов.</p>
                    <p>Подберём объект под ваш бюджет, поможем с ипотекой, проверим юридическую чистоту.</p>
                    <a href="{{ route('contacts') }}" class="btn btn-primary">Записаться на консультацию</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection