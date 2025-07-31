<div class="row">
    <form method="GET" action="{{ route('home') }}" class="mb-4" id="filterForm">
        {{-- Тип недвижимости отдельно сверху --}}
        <div class="mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <label class="filter-label d-block mb-1"><b class="fs-2rem fst-italic">Выбрать</b></label>
                <select 
                    name="type" 
                    id="type" 
                    class="form-select navbar-select" 
                    style="max-width: 250px;"
                >
                    <option value="">Любую недвижимость</option>
                    <option value="квартира" {{ request('type') == 'квартира' ? 'selected' : '' }}>Квартиру</option>
                    <option value="дом" {{ request('type') == 'дом' ? 'selected' : '' }}>Дом</option>
                    <option value="коммерческая" {{ request('type') == 'коммерческая' ? 'selected' : '' }}>Коммерческую</option>
                </select>
            </div>
        </div>

        {{-- Остальные фильтры --}}
        <div class="row align-items-end g-3">
            {{-- Цена --}}
            <div class="col-md-3">
                <label class="filter-label d-block mb-1 text-center">Стоимость ₽</label>
                <div class="d-flex justify-content-between text-small text-muted p-3">
                    <span id="price-min-value">₽{{ number_format(request('price_range_min', $minPrice), 2, '.', ' ') }}</span>
                    <span id="price-max-value">₽{{ number_format(request('price_range_max', $maxPrice), 2, '.', ' ') }}</span>
                </div>
                <div id="price-range-slider"></div>
                <input type="hidden" name="price_range_min" id="price-range-min" value="{{ request('price_range_min', $minPrice) }}">
                <input type="hidden" name="price_range_max" id="price-range-max" value="{{ request('price_range_max', $maxPrice) }}">
            </div>

            {{-- Комнаты --}}
            <div class="col-md-3">
                <label class="filter-label d-block mb-1 text-center ">Количество комнат</label>
                <div class="room-buttons pt-3 pl-3 pr-3 pe-3 ps-3">
                    <label class="room-button-text">
                        <input type="radio" name="rooms" value="0" {{ request('rooms') === '0' ? 'checked' : '' }}>
                        <span>Студия</span>
                    </label>
                    @foreach([1, 2, 3] as $room)
                        <label class="room-button">
                            <input type="radio" name="rooms" value="{{ $room }}" {{ request('rooms') == $room ? 'checked' : '' }}>
                            <span>{{ $room }}</span>
                        </label>
                    @endforeach
                    <label class="room-button">
                        <input type="radio" name="rooms" value="4" {{ request('rooms') == '4' ? 'checked' : '' }}>
                        <span>4+</span>
                    </label>
                </div>
            </div>

            {{-- Площадь --}}
            <div class="col-md-3">
                <label class="filter-label d-block mb-1 text-center">Площадь, м²</label>
                <div class="d-flex justify-content-between text-small text-muted p-3">
                    <span id="area-min-value">{{ request('area_range_min', 20) }}</span>
                    <span id="area-max-value">{{ request('area_range_max', 200) }}</span>
                </div>
                <div id="area-range-slider"></div>
                <input type="hidden" name="area_range_min" id="area-range-min" value="{{ request('area_range_min', 20) }}">
                <input type="hidden" name="area_range_max" id="area-range-max" value="{{ request('area_range_max', 200) }}">
            </div>

            {{-- Кнопки --}}
            <div class="col-md-3 d-flex align-items-center justify-content-center gap-3 pt-3 ps-3 pe-3">
                <button type="submit" class="btn-show">
                    Показать
                </button>
                <button type="button" class="btn-reset" id="resetFilters">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.65 6.35A7.958 7.958 0 0 0 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0 1 12 18c-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>