@extends('layouts.auth')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-attachment: fixed;
        overflow-x: hidden;
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
                    <h1 class="login-title">Создать аккаунт</h1>
                    <p class="login-subtitle">Заполните поля ниже, чтобы зарегистрироваться</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="form">
                    <input type="hidden" name="custom_csrf_token" value="{{ $custom_csrf_token }}">

                    <div class="mb-4">
                        <label for="name" class="form-label">Имя</label>
                        <input id="name" type="text" class="form-control custom-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Ваше имя">
                        @error('name')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control custom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="example@mail.com">
                        @error('email')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Пароль</label>
                        <input id="password" type="password" class="form-control custom-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Подтвердите пароль</label>
                        <input id="password-confirm" type="password" class="form-control custom-input" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                    </div>

                    <div class="mb-4">
                        <div class="form-check d-flex align-items-center">
                            <input type="checkbox" name="privacy_policy" id="privacy-policy" class="form-check-input custom-checkbox @error('privacy_policy') is-invalid @enderror" required>
                            <label for="privacy-policy" class="form-check-label ms-2">
                                <a href="/privacy-policy" target="_blank" class="text-center" style="font-size: 10px;">Принимаю условия регистрации и соглашаюсь на обработку персональных данных</a>
                            </label>
                            @error('privacy_policy')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-3 mt-4">
                        <button type="submit" class="btn iphone-button btn-register">
                            <i class="fas fa-user-plus me-2"></i> Зарегистрироваться
                        </button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center">
                        <i class="fas fa-arrow-left me-1"></i> Вернуться на главную
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection