@extends('layouts.auth')
@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-sm-7 col-md-5 ">
            <div class="login-form">
                <h1 class="login-title">Войти в личный <br> кабинет</h1>
                <p class="login-subtitle">Пожалуйста, заполните поля ниже для входа в систему</p>

                <form method="POST" action="{{ route('login') }}" class="form">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label text-left text-dark">Адрес электронной почты</label>
                        <input id="email" type="email" class="form-control custom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-left text-dark">Пароль</label>
                        <input id="password" type="password" class="form-control custom-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input custom-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-dark" for="remember">Запомнить меня</label>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2 mt-4">
                        <button type="submit" class="btn iphone-button btn-login">Войти</button>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="btn iphone-button btn-forgot">Забыли пароль?</a>
                        @endif

                        <a href="{{ route('register') }}" class="btn iphone-button btn-register">Регистрация</a>
                    </div>
                </form>
            </div>
        </div>
        <div class=" col-sm-5 col-md-7 gradient-bg d-flex justify-content-center align-items-center">
            <img src="{{ asset('storage/images/home_login.webp') }}" 
                 alt="Home Login Image" 
                 class="img-fluid d-none d-sm-block" 
                 style="width: 330px; height: auto; object-fit: contain;">
        </div>
    </div>
</div>
@endsection