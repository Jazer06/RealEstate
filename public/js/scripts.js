
$(document).ready(function() {
    // =============== КНОПКА "НАВЕРХ" ===============
    const $backToTop = $('#backToTop');

$(window).on('scroll', function () {
    const scrollTop = $(window).scrollTop();
    const docHeight = $(document).height();
    const winHeight = $(window).height();
    const scrollPercent = scrollTop / (docHeight - winHeight);

    if (scrollPercent > 0.25) {
        $backToTop.addClass('show');
    } else {
        $backToTop.removeClass('show');
    }
});

    // Плавная прокрутка наверх
    $backToTop.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 'smooth');
    });

    // =============== КАРУСЕЛЬ ===============
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


    const $thumbCarousel = $('.custom-thumbs-container').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.carousel-inner',
        focusOnSelect: true,
        arrows: false,
        infinite: true, // лучше true, чтобы цикл был
        centerMode: true, // 🔥 ВАЖНО: активный слайд по центру

        infinite: false,
        centerMode: false,
        variableWidth: false,
       responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    centerMode: true
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 5,
                    centerMode: true

                }
            },
            {
                breakpoint: 768,
                settings: {
                     centerPadding: '15px',
                    slidesToShow: 1.8,
                    infinite: false,
                    centerMode: true
                }
            }
        ]
    });

    $('.thumb-item').on('click', function(e) {
        e.preventDefault();
        const index = $(this).data('slide-index');
        $mainCarousel.slick('slickGoTo', index);
    });

    $mainCarousel.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $('.thumb-item').removeClass('active');
        $('.thumb-item').eq(nextSlide).addClass('active');
        $thumbCarousel.slick('slickGoTo', nextSlide);
    });

    $('.carousel-nav-btn.up').on('click', function() {
        $mainCarousel.slick('slickPrev');
    });

    $('.carousel-nav-btn.down').on('click', function() {
        $mainCarousel.slick('slickNext');
    });

    $('.carousel-inner .carousel-slide').on('click', function(e) {
        if (!$(e.target).closest('.custom-thumbs-container').length) {
            $mainCarousel.slick('slickNext');
        }
    });

    // =============== СЛАЙДЕР ЦЕН ===============

    const priceSlider = document.getElementById('price-range-slider');
    const priceMinInput = document.getElementById('price-range-min');
    const priceMaxInput = document.getElementById('price-range-max');
    const priceMinInputField = document.getElementById('price-min-input');
    const priceMaxInputField = document.getElementById('price-max-input');
    const minPrice = window.appConfig.minPrice;
    const maxPrice = window.appConfig.maxPrice;

    if (priceSlider && priceMinInput && priceMaxInput && priceMinInputField && priceMaxInputField) {
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

        // Обновление скрытых полей и полей ввода при изменении слайдера
        priceSlider.noUiSlider.on('update', (values, handle) => {
            if (handle === 0) {
                priceMinInput.value = values[0];
                priceMinInputField.value = values[0];
            } else {
                priceMaxInput.value = values[1];
                priceMaxInputField.value = values[1];
            }
        });

        // Обработка ручного ввода для минимальной цены
        priceMinInputField.addEventListener('change', () => {
            let value = parseFloat(priceMinInputField.value) || minPrice;
            value = Math.max(minPrice, Math.min(value, parseFloat(priceMaxInputField.value) || maxPrice));
            priceSlider.noUiSlider.set([value, null]);
        });

        // Обработка ручного ввода для максимальной цены
        priceMaxInputField.addEventListener('change', () => {
            let value = parseFloat(priceMaxInputField.value) || maxPrice;
            value = Math.min(maxPrice, Math.max(value, parseFloat(priceMinInputField.value) || minPrice));
            priceSlider.noUiSlider.set([null, value]);
        });
    }
        // =============== СЛАЙДЕР ПЛОЩАДИ ===============
    const areaSlider = document.getElementById('area-range-slider');
    const areaMinInput = document.getElementById('area-range-min');
    const areaMaxInput = document.getElementById('area-range-max');
    const areaMinInputField = document.getElementById('area-min-input');
    const areaMaxInputField = document.getElementById('area-max-input');

    if (areaSlider && areaMinInput && areaMaxInput && areaMinInputField && areaMaxInputField) {
        noUiSlider.create(areaSlider, {
            start: [
                parseInt(areaMinInput.value) || 20,
                parseInt(areaMaxInput.value) || 200
            ],
            connect: true,
            range: { 'min': 10, 'max': 500 },
            step: 1
        });

        // Обновление скрытых полей и полей ввода при изменении слайдера
        areaSlider.noUiSlider.on('update', (values, handle) => {
            if (handle === 0) {
                areaMinInput.value = Math.round(values[0]);
                areaMinInputField.value = Math.round(values[0]);
            } else {
                areaMaxInput.value = Math.round(values[1]);
                areaMaxInputField.value = Math.round(values[1]);
            }
        });

        // Обработка ручного ввода для минимальной площади
        areaMinInputField.addEventListener('change', () => {
            let value = parseInt(areaMinInputField.value) || 10;
            value = Math.max(10, Math.min(value, parseInt(areaMaxInputField.value) || 500));
            areaSlider.noUiSlider.set([value, null]);
        });

        // Обработка ручного ввода для максимальной площади
        areaMaxInputField.addEventListener('change', () => {
            let value = parseInt(areaMaxInputField.value) || 500;
            value = Math.min(500, Math.max(value, parseInt(areaMinInputField.value) || 10));
            areaSlider.noUiSlider.set([null, value]);
        });
    }

    // =============== ВСПОМОГАТЕЛЬНАЯ ФУНКЦИЯ ===============
    function number_format(number, decimals = 0) {
        return parseFloat(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }

    // =============== ПРОКРУТКА К ЯКОРЮ #filters ===============
    const hash = window.location.hash;

    if (hash === '#filters') {
        const $filterSection = $('.filter-glass');

        if ($filterSection.length) {
            setTimeout(() => {
                $('html, body').animate({
                    scrollTop: $filterSection.offset().top - 20
                }, 800);
            }, 50);
        }
    }

    // =============== СБРОС ФИЛЬТРОВ ===============
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

    // =============== ФОРМАТИРОВАНИЕ ТЕЛЕФОНА ===============
    function formatPhoneInput(phoneInput) {
        if (!phoneInput) return;

        if (!phoneInput.value) {
            phoneInput.value = '+7';
        }

        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value;
            let digits = value.replace(/\D/g, '');

            if (digits.startsWith('8')) {
                digits = '7' + digits.slice(1);
            }
            if (digits && !digits.startsWith('7')) {
                digits = '7' + digits;
            }
            digits = digits.substring(0, 11);

            let formatted = '';
            if (digits) {
                formatted = '+7';
                if (digits.length > 1) formatted += ' (' + digits.slice(1, 4);
                if (digits.length > 4) formatted += ') ' + digits.slice(4, 7);
                if (digits.length > 7) formatted += '-' + digits.slice(7, 9);
                if (digits.length > 9) formatted += '-' + digits.slice(9, 11);
            }

            if (formatted !== e.target.value) {
                e.target.value = formatted;
            }
        });

        phoneInput.addEventListener('keydown', function(e) {
            const start = e.target.selectionStart;
            if (['Backspace', 'Delete'].includes(e.key) && start <= 3 && e.target.value.startsWith('+7')) {
                e.preventDefault();
            }
        });

        phoneInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const digits = paste.replace(/\D/g, '');
            const event = new Event('input', { bubbles: true });
            e.target.value = '+7';
            setTimeout(() => {
                e.target.value = '';
                e.target.value = '+7';
                e.target.dispatchEvent(event);
                for (let char of digits) {
                    e.target.value += char;
                    e.target.dispatchEvent(event);
                }
            }, 1);
        });

        phoneInput.addEventListener('focus', function() {
            if (this.value === '') {
                this.value = '+7';
            }
        });
    }

    const phoneInputs = [
        document.getElementById('contact-phone'),
        document.getElementById('consult-phone'),
        document.getElementById('profile-phone'),
        document.getElementById('consultation-phone'),
        document.getElementById('modal-phone')
    ].filter(input => input);

    phoneInputs.forEach(formatPhoneInput);
});
