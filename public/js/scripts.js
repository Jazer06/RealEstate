$(document).ready(function() {


    // Initialize main carousel first
    const $mainCarousel = $('.carousel-inner').slick({
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false,
        dots: false,
        fade: true,
        speed: 800,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: '.custom-thumbs-container'
    });

    // Initialize thumbnail carousel after main carousel
    const $thumbCarousel = $('.custom-thumbs-container').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.carousel-inner',
        focusOnSelect: true,
        arrows: false,
        infinite: false,
        centerMode: false,
        variableWidth: false,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    // Handle thumbnail clicks
    $('.thumb-item').on('click', function(e) {
        e.preventDefault();
        const index = $(this).data('slide-index');
        $mainCarousel.slick('slickGoTo', index);
    });

    // Update active thumbnail on main carousel change
    $mainCarousel.on('beforeChange', function(event, slick, currentSlide, nextSlide) {

        $('.thumb-item').removeClass('active');
        $('.thumb-item').eq(nextSlide).addClass('active');
        $thumbCarousel.slick('slickGoTo', nextSlide);
    });

    // Handle navigation buttons
    $('.carousel-nav-btn.up').on('click', function() {
        $mainCarousel.slick('slickPrev');
    });

    $('.carousel-nav-btn.down').on('click', function() {
        $mainCarousel.slick('slickNext');
    });

    // Optional: Handle click on main slide to go to next
    $('.carousel-inner .carousel-slide').on('click', function(e) {
        if (!$(e.target).closest('.custom-thumbs-container').length) {
            $mainCarousel.slick('slickNext');
        }
    });

    // Цена
    const priceSlider = document.getElementById('price-range-slider');
    const priceMinInput = document.getElementById('price-range-min');
    const priceMaxInput = document.getElementById('price-range-max');
    const priceMinValue = document.getElementById('price-min-value');
    const priceMaxValue = document.getElementById('price-max-value');
    const minPrice = window.appConfig.minPrice;
    const maxPrice = window.appConfig.maxPrice;

    if (priceSlider && priceMinInput && priceMaxInput && priceMinValue && priceMaxValue) {
        noUiSlider.create(priceSlider, {
            start: [
                parseFloat(priceMinInput.value) || minPrice,
                parseFloat(priceMaxInput.value) || maxPrice
            ],
            connect: true,
            range: { 'min': minPrice, 'max': maxPrice },
            step: 10000,
            format: {
                to: value => Math.round(value),
                from: value => Number(value)
            }
        });

        priceSlider.noUiSlider.on('update', (values, handle) => {
            if (handle === 0) {
                priceMinInput.value = values[0];
                priceMinValue.textContent = '₽' + number_format(values[0]);
            } else {
                priceMaxInput.value = values[1];
                priceMaxValue.textContent = '₽' + number_format(values[1]);
            }
        });
    }

    // Площадь
    const areaSlider = document.getElementById('area-range-slider');
    const areaMinInput = document.getElementById('area-range-min');
    const areaMaxInput = document.getElementById('area-range-max');
    const areaMinValue = document.getElementById('area-min-value');
    const areaMaxValue = document.getElementById('area-max-value');

    if (areaSlider && areaMinInput && areaMaxInput && areaMinValue && areaMaxValue) {
        noUiSlider.create(areaSlider, {
            start: [
                parseInt(areaMinInput.value) || 20,
                parseInt(areaMaxInput.value) || 200
            ],
            connect: true,
            range: { 'min': 10, 'max': 500 },
            step: 1
        });

        areaSlider.noUiSlider.on('update', (values, handle) => {
            if (handle === 0) {
                areaMinInput.value = Math.round(values[0]);
                areaMinValue.textContent = Math.round(values[0]);
            } else {
                areaMaxInput.value = Math.round(values[1]);
                areaMaxValue.textContent = Math.round(values[1]);
            }
        });
    }

    // Сброс фильтров
    document.getElementById('resetFilters')?.addEventListener('click', () => {
        if (priceSlider && priceSlider.noUiSlider) {
            priceSlider.noUiSlider.set([minPrice, maxPrice]);
        }
        if (areaSlider && areaSlider.noUiSlider) {
            areaSlider.noUiSlider.set([20, 200]);
        }
        document.querySelectorAll('input[name="rooms"]').forEach(r => r.checked = false);
        if (document.getElementById('type')) {
            document.getElementById('type').value = '';
        }
        if (document.getElementById('filterForm')) {
            document.getElementById('filterForm').submit();
        }
    });

    // Форматирование полей телефона
    function formatPhoneInput(phoneInput) {
        if (!phoneInput) return;

        // Восстанавливаем значение или ставим +7
        if (!phoneInput.value) {
            phoneInput.value = '+7';
        }

        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value;
            let digits = value.replace(/\D/g, '');

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
        phoneInput.addEventListener('keydown', function(e) {
            const start = e.target.selectionStart;
            if (['Backspace', 'Delete'].includes(e.key) && start <= 3 && e.target.value.startsWith('+7')) {
                e.preventDefault();
            }
        });

        // При вставке — чистим
        phoneInput.addEventListener('paste', function(e) {
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
        phoneInput.addEventListener('focus', function() {
            if (this.value === '') {
                this.value = '+7';
            }
        });
    }

    // Применяем форматирование ко всем полям телефона
    const phoneInputs = [
        document.getElementById('contact-phone'),
        document.getElementById('consult-phone'),
        document.getElementById('profile-phone'),
        document.getElementById('consultation-phone'),
        document.getElementById('modal-phone')
    ].filter(input => input); // Фильтруем null элементы

    phoneInputs.forEach(formatPhoneInput);

    function number_format(number, decimals = 0) {
        return parseFloat(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }
});