@extends('layouts.app')

@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="avatarForm" class="avatar-form">
                        @csrf
                        @method('PUT')
                        <div class="avatar-container" style="position: relative; display: inline-block;">
                            @if (auth()->user()->avatar)
                              <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ auth()->user()->name }}" class="rounded-circle avatar-img" style="width: 150px; height: 150px; object-fit: cover; margin-bottom: 1rem; cursor: pointer;" onclick="document.getElementById('avatarInput').click();">
                            @else
                                <div style="height: 150px; width: 150px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-bottom: 1rem; cursor: pointer;" class="avatar-img" onclick="document.getElementById('avatarInput').click();">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
<input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none" onchange="this.form.submit();">
                            @error('avatar')
                                <span class="invalid-feedback d-block text-center">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                    <h2 class="card-title">{{ auth()->user()->name }}</h2>
                    <p class="text-muted">{{ auth()->user()->role ?? 'Пользователь' }}</p>
                    <button type="button" class="btn iphone-button btn-login mt-3" data-bs-toggle="modal" data-bs-target="#profileActionsModal">Настройки профиля</button>
                </div>
            </div>
        </div>

        <!-- Модалка для действий (оставляем без изменений) -->
        <div class="modal fade" id="profileActionsModal" tabindex="-1" aria-labelledby="profileActionsModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-right modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profileActionsModalLabel">Действия</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (auth()->check())
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="surname" class="form-label text-left text-dark">Фамилия</label>
                                    <input id="surname" type="text" class="form-control custom-input @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname', auth()->user()->surname ?? '') }}" required>
                                    @error('surname')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label text-left text-dark">Имя</label>
                                    <input id="name" type="text" class="form-control custom-input @error('name') is-invalid @enderror" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="patronymic" class="form-label text-left text-dark">Отчество</label>
                                    <input id="patronymic" type="text" class="form-control custom-input @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ old('patronymic', auth()->user()->patronymic ?? '') }}" required>
                                    @error('patronymic')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label text-left text-dark">Телефон</label>
                                    <input id="phone" type="text" class="form-control custom-input @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                                    @error('phone')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label text-left text-dark">E-mail</label>
                                    <input id="email" type="email" class="form-control custom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label text-left text-dark">Новый пароль</label>
                                    <input id="new_password" type="password" class="form-control custom-input @error('new_password') is-invalid @enderror" name="new_password">
                                    @error('new_password')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label text-left text-dark">Подтвердить пароль</label>
                                    <input id="new_password_confirmation" type="password" class="form-control custom-input @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation">
                                    @error('new_password_confirmation')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <p class="text-left text-dark"><i>Чтобы поменять ФИО, телефон или email, обратитесь в центр клиентской поддержки</i></p>
                                </div>

                                <div class="d-flex flex-column gap-2 mt-4">
                                    <button type="submit" class="btn iphone-button btn-login">Сохранить</button>
                                </div>
                            </form>
                        @else
                            <p class="text-center">Пожалуйста, <a href="{{ route('login') }}" class="text-decoration-none">войдите</a> в систему для настройки профиля.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Контактная информация</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Email:</strong> {{ auth()->user()->email }}
                        </li>
                        <li class="list-group-item">
                            <strong>Телефон:</strong> {{ auth()->user()->phone ?? 'Не указан' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

<style>
    
    .avatar-form {
    margin: 0;
    }
    .avatar-img {
        transition: transform 0.2s;
    }
    .avatar-img:hover {
        transform: scale(1.05);
    }
</style>
