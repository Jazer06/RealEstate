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
            Ссылка для сброса пароля отправлена на ваш email.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="color: #a0f0c0;"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mx-auto" role="alert" style="max-width: 440px; background: rgba(229, 62, 62, 0.2); border: 1px solid rgba(229, 62, 62, 0.3); backdrop-filter: blur(8px); color: #fbb;">
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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="color: #fbb;"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="login-card">
                <div class="text-center mb-4">
                    <h1 class="login-title">Восстановить пароль</h1>
                    <p class="login-subtitle">Введите email, чтобы сбросить пароль</p>
                </div>

                <form method="POST" action="{{ route('password.email') }}" id="passwordResetForm" class="form">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control custom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="example@mail.com">
                        @error('email')
                            <div class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid gap-3 mt-4">
                        <button type="submit" class="btn iphone-button btn-login" id="submitBtn">
                            <i class="fas fa-envelope me-2"></i> Отправить ссылку
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('passwordResetForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Отправка...';
    });
});
</script>
@endpush