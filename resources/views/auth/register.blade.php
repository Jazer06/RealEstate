@extends('layouts.auth')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-7 col-md-5 ">
            <div class="auth-form">
                <h2 class="login-title mb-4">Создать аккаунт</h2>
                <p class="login-subtitle mb-4">Заполните поля ниже, чтобы зарегистрироваться</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label text-left text-dark">Имя</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label text-left text-dark">Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-left text-dark">Пароль</label>
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
                        <label for="password-confirm" class="form-label text-left text-dark">Подтвердите пароль</label>
                        <input id="password-confirm" type="password"
                               class="form-control"
                               name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn iphone-button btn-login">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
        </div>
        <div class=" col-sm-5 col-md-7 gradient-bg d-flex justify-content-center align-items-center">
            <img src="{{ asset('storage/images/home_registration.webp') }}" 
                 alt="Home Login Image" 
                 class="img-fluid d-none d-sm-block" 
                 style="width: 330px; height: auto; object-fit: contain;">
        </div>
    </div>
</div>
@endsection