@extends('layouts.auth')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <!-- Ваша форма восстановления пароля -->
            <div class="auth-form">
                <h2 class="login-title mb-4">Восстановить пароль</h2>
                <p class="login-subtitle mb-4">Введите email, чтобы сбросить пароль</p>

                @if (session('status'))
                    <div class="alert alert-success mb-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label text-left text-dark">Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn iphone-button btn-login">Отправить ссылку</button>
                    </div>
                </form>
            </div>
        </div>
        <div class=" col-sm-5 col-md-7 gradient-bg d-flex justify-content-center align-items-center">
            <img src="{{ asset('storage/images/home_reset.webp') }}" 
                 alt="Home Login Image" 
                 class="img-fluid d-none d-sm-block" 
                 style="width: 380px; height: auto; object-fit: contain;">
        </div>
    </div>
</div>
@endsection