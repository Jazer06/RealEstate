
<div class="mt-9 mb-3">
    <div class="contact-container">
        <div class="contact-form">
            <h2 class="text-center text-2xl font-bold text-light mb-4">Свяжитесь с нами</h2>

            <form method="POST" action="{{ route('contact.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Имя -->
                <div class="mb-3">
                    <label for="name" class="form-label">Ваше Имя</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        maxlength="20"
                        pattern="[а-яА-ЯёЁa-zA-Z\s\-]+"
                        title="Только буквы, пробелы и дефисы"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Телефон -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Ваш Телефон</label>
                    <input
                        id="phone"
                        type="tel"
                        class="form-control @error('phone') is-invalid @enderror"
                        name="phone"
                        placeholder="+7 (xxx) xxx-xx-xx"
                        maxlength="18"
                        autocomplete="off"
                        inputmode="numeric"
                        value="{{ old('phone') ?: '+7' }}"
                        required
                    >
                    @error('phone')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                    @enderror
                </div>

                <!-- Описание -->
                <div class="mb-3">
                    <label for="description_type" class="form-label">Причина обращения</label>
                    <select
                        name="description_type"
                        id="description_type"
                        class="form-control mb-2"
                        onchange="document.getElementById('description').value = this.value"
                    >
                        <option value="">Выберите тип</option>
                        <option value="Покупка недвижимости">Покупка недвижимости</option>
                        <option value="Консультация">Консультация</option>
                        <option value="Другое">Другое</option>
                    </select>

                    <label for="description" class="form-label">Описание</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                        maxlength="100"
                        required
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Отправить</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const phoneInput = document.getElementById('phone');

    if (!phoneInput) return;

    // Восстанавливаем значение или ставим +7
    if (!phoneInput.value) {
        phoneInput.value = '+7';
    }

    phoneInput.addEventListener('input', function (e) {
        let value = e.target.value;
        let digits = value.replace(/\D/g, ''); // Только цифры

        // Если начинается на 8 → заменяем на 7
        if (digits.startsWith('8')) {
            digits = '7' + digits.slice(1);
        }

        // Если нет 7 в начале и есть цифры → добавляем 7
        if (digits && !digits.startsWith('7')) {
            digits = '7' + digits;
        }

        // Ограничение: 11 цифр (7 + 10)
        digits = digits.substring(0, 11);

        // Форматируем
        let formatted = '';
        if (digits) {
            formatted = '+7';
            if (digits.length > 1) {
                formatted += ' (' + digits.slice(1, 4);
            }
            if (digits.length > 4) {
                formatted += ') ' + digits.slice(4, 7);
            }
            if (digits.length > 7) {
                formatted += '-' + digits.slice(7, 9);
            }
            if (digits.length > 9) {
                formatted += '-' + digits.slice(9, 11);
            }
        }

        // Обновляем, только если изменилось
        if (formatted !== e.target.value) {
            e.target.value = formatted;
        }
    });

    // Защита от удаления +7
    phoneInput.addEventListener('keydown', function (e) {
        const start = e.target.selectionStart;
        if (['Backspace', 'Delete'].includes(e.key) && start <= 3 && e.target.value.startsWith('+7')) {
            e.preventDefault();
        }
    });

    // При вставке — чистим
    phoneInput.addEventListener('paste', function (e) {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text');
        const digits = paste.replace(/\D/g, '');
        const event = new Event('input', { bubbles: true });
        e.target.value = '+7'; // сбрасываем
        setTimeout(() => {
            e.target.value = ''; // чтобы сработал input
            e.target.value = '+7';
            e.target.dispatchEvent(event);
            // Добавим цифры
            for (let char of digits) {
                e.target.value += char;
                e.target.dispatchEvent(event);
            }
        }, 1);
    });

    // При фокусе — если пусто, ставим +7
    phoneInput.addEventListener('focus', function () {
        if (this.value === '') {
            this.value = '+7';
        }
    });
});
</script>