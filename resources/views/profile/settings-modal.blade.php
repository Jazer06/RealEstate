<!-- Modal -->
<div class="modal fade" id="profileSettingsModal" tabindex="-1" aria-labelledby="profileSettingsModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-right modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileSettingsModalLabel">Настройки профиля</h5>
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
<style>
        /* Стили для модалки, выезжающей справа */
    .modal-dialog-right {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        width: 400px; /* Ширина модалки, можешь подогнать под дизайн */
        max-width: 100%;
    }

    .modal.show .modal-dialog-right {
        transform: translateX(0);
    }

    .modal-content {
        height: 100%;
        border-radius: 0;
        border-left: none;
        overflow-y: auto;
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
    }

    .modal-body {
        padding: 2rem;
    }

    /* Убираем фон затемнения, если нужно, чтобы модалка выглядела как панель */
    .modal-backdrop {
        display: none !important;
    }

    /* Дополнительно: стили для адаптивности */
    @media (max-width: 768px) {
        .modal-dialog-right {
            width: 100%;
        }
    }
</style>