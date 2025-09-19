@extends('layouts.auth')

@section('content')
<style>
body {
    min-height: 100vh;
    background: 
        linear-gradient(135deg, rgba(26,26,26,0.8) 0%, rgba(44,44,44,0.8) 100%),
        url("/storage/banner-image/image-mobile.webp") no-repeat center center;
        background-size: cover;
}


</style>

<div class="container">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mx-auto" role="alert" style="max-width: 440px; background: rgba(40, 167, 69, 0.2); border: 1px solid rgba(40, 167, 69, 0.3); backdrop-filter: blur(8px); color: #a0f0c0;">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="color: #a0f0c0;"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="login-card">
                <div class="text-center mb-4">
                    <h1 class="login-title">Смена пароля</h1>
                    <p class="login-subtitle">Пожалуйста, введите новый пароль</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $resetEmail }}">

                    <div class="mb-4">
                        <label for="password" class="form-label">Новый пароль</label>
                        <input id="password" type="password" class="form-control custom-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                        <input id="password_confirmation" type="password" class="form-control custom-input" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                    </div>

                    <div class="d-grid gap-3 mt-4">
                        <button type="submit" class="btn iphone-button btn-login">
                            <i class="fas fa-key me-2"></i> Сменить пароль
                        </button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="d-inline-flex align-items-center">
                        <i class="fas fa-arrow-left me-1"></i> Вернуться к входу
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection