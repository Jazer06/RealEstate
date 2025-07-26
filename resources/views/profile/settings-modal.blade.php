

<!-- Modal -->
<div class="modal fade" id="profileSettingsModal" tabindex="-1" aria-labelledby="profileSettingsModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-right modal-dialog-scrollable black-glass-border-left">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileSettingsModalLabel">Настройки профиля</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (auth()->check())
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')
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
                            <label for="phone" class="form-label text-left text-dark">Телефон</label>
                            <input id="phone" type="tel" class="form-control custom-input @error('phone') is-invalid @enderror" 
                                   name="phone" 
                                   placeholder="+7 (xxx) xxx-xx-xx" 
                                   maxlength="18"
                                   autocomplete="off"
                                   inputmode="numeric">
                            @error('phone')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label text-left text-dark">Новый пароль</label>
                            <input id="new_password" type="password" class="form-control custom-input @error('new_password') is-invalid @enderror" name="new_password" autocomplete="new-password">
                            @error('new_password')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label text-left text-dark">Подтвердить пароль</label>
                            <input id="new_password_confirmation" type="password" class="form-control custom-input @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" autocomplete="new-password">
                            @error('new_password_confirmation')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex flex-column gap-2 mt-4">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <button type="submit" class="iphone-button-black">Сохранить</button>
                        </div>
                    </form>
                @else
                    <p class="text-center">Пожалуйста, <a href="{{ route('login') }}" class="text-decoration-none">войдите</a> в систему для настройки профиля.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('phone');
    
    if (phoneInput) {
        // Инициализация - очищаем поле
        phoneInput.value = '';
        
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            
            // Если пользователь начал ввод с цифры (не с +7)
            if (value.length > 0 && !e.target.value.startsWith('+7')) {
                value = '7' + value; // Добавляем 7 в начало
            }
            
            // Ограничиваем длину (11 цифр, включая 7)
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            
            // Форматируем: +7 (XXX) XXX-XX-XX
            if (value.length > 0) {
                formattedValue = '+7';
                
                if (value.length > 1) {
                    formattedValue += ' (' + value.substring(1, 4);
                }
                if (value.length > 4) {
                    formattedValue += ') ' + value.substring(4, 7);
                }
                if (value.length > 7) {
                    formattedValue += '-' + value.substring(7, 9);
                }
                if (value.length > 9) {
                    formattedValue += '-' + value.substring(9, 11);
                }
            }
            
            e.target.value = formattedValue;
        });
        
        // Обработка фокуса - добавляем +7 если поле пустое
        phoneInput.addEventListener('focus', function(e) {
            if (e.target.value === '') {
                e.target.value = '+7';
            }
        });
        
        // Обработка удаления
        phoneInput.addEventListener('keydown', function(e) {
            // Если пытаемся удалить +7
            if (e.key === 'Backspace' && e.target.selectionStart <= 3) {
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>

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
        width: 400px;
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
        color: black;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 35px;
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
    }

    .modal-body {
        padding: 2rem;
    }

    /* Убираем фон затемнения */
    .modal-backdrop {
        display: none !important;
    }

    /* Адаптивность */
    @media (max-width: 768px) {
        .modal-dialog-right {
            width: 100%;
        }
    }
</style>