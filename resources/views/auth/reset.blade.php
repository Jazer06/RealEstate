@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Форма смены пароля -->
        <div class="col-md-4">
            <div class="auth-form">
                <h2 class="login-title mb-4">Смена пароля</h2>
                <p class="login-subtitle mb-4">Пожалуйста, введите новый пароль</p>

                @if (session('status'))
                    <div class="alert alert-success mb-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $resetEmail }}">

                    <div class="mb-3">
                        <label for="password" class="form-label text-left text-dark">Новый пароль</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label text-left text-dark">Подтвердите пароль</label>
                        <input id="password_confirmation" type="password"
                               class="form-control"
                               name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn iphone-button btn-login">Сменить пароль</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Изображение справа -->
        <div class="col-sm-5 col-md-7 gradient-bg d-flex justify-content-center align-items-center">
            <img src="{{ asset('storage/images/home_reset.webp') }}"
                 alt="Reset Password Image"
                 class="img-fluid d-none d-sm-block"
                 style="width: 380px; height: auto; object-fit: contain;">
        </div>
    </div>
</div>
@endsection