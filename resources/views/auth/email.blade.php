@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Форма восстановления пароля -->
        <div class="col-md-4">
            <div class="auth-form">
                <h2 class="login-title mb-4">Восстановить пароль</h2>
                <p class="login-subtitle mb-4">Введите email, чтобы сбросить пароль</p>

                @if (session('status'))
                    <div class="alert alert-success mb-3" role="alert">
                        Ссылка для сброса пароля отправлена на ваш email.
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ str_replace([
                                    'The email field is required.',
                                    'The email must be a valid email address.'
                                ], [
                                    'Поле Email обязательно.',
                                    'Email должен быть корректным.'
                                ], $error) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" id="passwordResetForm">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label text-left text-dark">Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               required autocomplete="email" autofocus
                               placeholder="Ваш email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn iphone-button btn-login" id="submitBtn">
                            Отправить ссылку
                        </button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        ← Вернуться к входу
                    </a>
                </div>
            </div>
        </div>

        <!-- Изображение справа -->
        <div class="col-sm-5 col-md-7 gradient-bg d-flex justify-content-center align-items-center">
            <img src="{{ asset('storage/images/home_reset.webp') }}"
                 alt="Восстановление пароля"
                 class="img-fluid d-none d-sm-block"
                 style="width: 380px; height: auto; object-fit: contain;">
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('passwordResetForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function () {
        // Блокируем кнопку, чтобы избежать двойной отправки
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Отправка...';
    });
});
</script>
@endpush