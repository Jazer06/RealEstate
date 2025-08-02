<div class="mt-9 mb-3">
    <div class="contact-container">
        <div class="contact-form">
            <h2 class="text-center text-2xl font-bold text-black mb-4">Свяжитесь с нами</h2>
            <form method="POST" action="{{ route('contact.store') }}" enctype="multipart/form-data" id="contact-form">
                @csrf
                <!-- Имя -->
                <div class="mb-3">
                    <label for="contact-name" class="form-label">Ваше Имя</label>
                    <input
                        type="text"
                        name="name"
                        id="contact-name"
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
                    <label for="contact-phone" class="form-label">Ваш Телефон</label>
                    <input
                        id="contact-phone"
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
                <button type="submit" class="btn btn-primary w-100 mt-5">Отправить</button>
            </form>
        </div>
    </div>
</div>