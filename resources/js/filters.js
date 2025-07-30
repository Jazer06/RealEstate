$(document).ready(function() {
    // Цена
    const priceSlider = document.getElementById('price-range-slider');
    const priceMinInput = document.getElementById('price-range-min');
    const priceMaxInput = document.getElementById('price-range-max');
    const priceMinValue = document.getElementById('price-min-value');
    const priceMaxValue = document.getElementById('price-max-value');
    const minPrice = {{ $minPrice ?? 0 }};
    const maxPrice = {{ $maxPrice ?? 100000000 }};

    if (priceSlider && priceMinInput && priceMaxInput && priceMinValue && priceMaxValue) {
        noUiSlider.create(priceSlider, {
            start: [
                parseFloat(priceMinInput.value) || minPrice,
                parseFloat(priceMaxInput.value) || maxPrice
            ],
            connect: true,
            range: { min: minPrice, max: maxPrice },
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
            range: { min: 10, max: 500 },
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
        document.getElementById('type') && (document.getElementById('type').value = '');
        document.getElementById('filterForm')?.submit();
    });

    function number_format(number, decimals = 0) {
        return parseFloat(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }
});