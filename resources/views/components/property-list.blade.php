<style>
/* Контейнер основного контента (левая колонка + правая колонка) */
.container-obj {
    display: flex;
    gap: 1rem;
    padding: 15px;
    background: white;
    backdrop-filter: blur(12px);
    align-items: flex-start;
    border-radius: 12px;
    border: 5px solid rgb(126 119 119 / 65%);
    flex-wrap: nowrap; /* не позволяй колонкам переноситься */
}

/* Левая колонка: фиксированная ширина, прокрутка, стили табов */
.item-obj.left,
.item-obj.col-12.col-md-2 {
    width: 260px;
    max-width: 30%;
    min-width: 200px;
    height: 75vh;
    box-sizing: border-box;
    background-color: white;
    border-radius: 12px;
    padding: 1rem 0;
    overflow-y: auto;
}

/* Стилизация контейнера вертикальных табов */
.container-obj .nav-pills {
    gap: 0.5rem;
    flex-direction: column;
    padding: 0 0.5rem;
}

/* Кнопки табов (изображения + эффекты) */
.container-obj .nav-pills .nav-link {
    padding: 0;
    border: 2px solid transparent;
    border-radius: 8px;
    transition: all 0.3s ease;
    opacity: 0.8;
    transform: scale(0.98);
    margin: 0 auto;
    width: calc(100% - 16px);
    overflow: hidden;
    position: relative;
}

.container-obj .nav-pills .nav-link:hover {
    opacity: 1;
    transform: scale(1);
    border-color:  #000000ad;
}

/* Активный таб — выделение */
.container-obj .nav-pills .nav-link.active {
    background-color: unset;
    transform: scale(1);
    font-weight: bold;
}

/* Изображение внутри таба */
.container-obj .nav-link img {
    border-radius: 6px;
    object-fit: cover;
    height: 100px;
    width: 100%;
    transition: transform 0.3s ease;
}

.container-obj .nav-link:hover img {
    transform: scale(1.05);
}


.card-footer-button { z-index: 20; }

</style>

<div class="container-obj mt-54">
    <div class="item-obj col-md-3 mt-54 d-none d-md-block" style="height: 65vh; overflow-y: auto;">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach ($sliders as $index => $slider)
            <div class="text-center bold">
               <b>
                   {{$slider->title}}
               </b> 
            </div>
                <button class="nav-link @if ($loop->first) active @endif"
                        id="v-pills-tab{{ $index + 1 }}-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#v-pills-tab{{ $index + 1 }}"
                        type="button"
                        role="tab"
                        aria-controls="v-pills-tab{{ $index + 1 }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    <img src="{{ $slider->image_path ? asset('storage/' . $slider->image_path) : 'https://via.placeholder.com/150x100' }}"
                         alt="{{ $slider->title }}"
                         class="w-100">
                </button>
            @endforeach
        </div>
    </div>

    <!-- Правая колонка: содержимое табов -->
    <div class="item-obj right col flex-grow-1 p-0">
        <div class="tab-content" id="v-pills-tabContent">
            @foreach ($sliders as $index => $slider)
                <div class="tab-pane fade @if ($loop->first) show active @endif"
                     id="v-pills-tab{{ $index + 1 }}"
                     role="tabpanel"
                     aria-labelledby="v-pills-tab{{ $index + 1 }}-tab">
                    <div class="mt-6">
                        <div class="container">
                            <div class="row">
                                <div class="text-center d-none d-md-block" style="margin-top: -80px"><h3>{{$slider->title}}</h3></div>
                                @forelse ($properties->where('slider_id', $slider->id) as $property)
                                    <div class="col-xl-6 mb-4">
                                        <div class="card property-card h-100 mb-2" onclick="window.location='{{ route('properties.show', $property->id) }}'">
                                            <div class="card-img-container">
                                                <img class="primary-img"
                                                     src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/300x200' }}"
                                                     alt="{{ $property->title }}">
                                                @if ($property->images()->where('is_plan', true)->first())
                                                    <img class="secondary-img"
                                                         src="{{ asset('storage/' . $property->images()->where('is_plan', true)->first()->image_path) }}"
                                                         alt="{{ $property->title }} - план дома">
                                                @endif
                                                <div class="card-footer-button"
                                                     style="position: absolute; top: 12px; right: 12px; padding: 15px;"
                                                     onclick="event.stopPropagation();">
                                                    @auth
                                                        <form action="{{ route('favorites.toggle', $property->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="favorite-icons {{ auth()->user()->favorites->contains($property->id) ? 'favorite-added' : '' }}"
                                                                    title="{{ auth()->user()->favorites->contains($property->id) ? 'Убрать из избранного' : 'Добавить в избранное' }}"
                                                                    style="border: none; background: none; cursor: pointer;">
                                                                <i class="bi bi-heart"></i>
                                                                @if (auth()->user()->favorites->contains($property->id))
                                                                    <i class="bi bi-x-lg"></i>
                                                                @endif
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('login') }}"
                                                           class="favorite-icon text-muted"
                                                           title="Войдите, чтобы добавить в избранное"
                                                           style="display: inline-block;">
                                                            <i class="bi bi-heart"></i>
                                                        </a>
                                                    @endauth
                                                </div>
                                            </div>

                                            <div class="card-body d-flex flex-column ">
                                                <div class="card-body-content flex-grow-1 ">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <p class="modal-property-title "  style="padding-top:10px">
                                                                <b>
                                                                    {{ $sliders->firstWhere('id', $property->slider_id)->title ?? $property->title }}
                                                                </b>
                                                            </p>
                                                            <h5 class="card-title fst-italic pt-2">{{ $property->title }}</h5>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6">
                                                            <p class="m-0" style="padding-top: 10px;">
                                                                @if($property->area)
                                                                    <strong>м²</strong> {{ number_format($property->area, 1, ',', ' ') }}
                                                                @endif
                                                            </p>
                                                            @if(!empty($property->address) && $property->address !== 'Адрес не указан')
                                                                <p class="m-0 d-none d-md-block" style="padding-top: 10px;">
                                                                    <strong>Адрес:</strong> {{ $property->address }}
                                                                </p>
                                                            @endif
                                                            <p class="card-text mb-2 d-none d-md-block" style="padding-top:10px">
                                                                @if($property->price > 0)
                                                                    <strong>Цена: {{ number_format($property->price, 0, ' ', ' ') }} ₽</strong>
                                                                @else
                                                                    @auth
                                                                        <form action="{{ route('favorites.toggle', $property->id) }}" method="POST" class="add-to-favorites-form mb-2 mt-2">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-outline-secondary" onclick="event.stopPropagation();">Узнать цену</button>
                                                                        </form>
                                                                    @else
                                                                        <a href="{{ route('login') }}" class="btn btn-outline-secondary" onclick="event.stopPropagation();">Узнать цену</a>
                                                                    @endauth
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p class="card-description p-2 ">
                                                            {{ $property->description ?? '' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p>Недвижимость не найдена.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
