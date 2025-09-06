<!-- Контейнер для избранных объектов -->
<div class="depth-card" style="background: #ffffff; border-radius: 12px; border: 1px solid #e9ecef; padding: 25px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
    <h4>Избранные объекты</h4>
    <div class="row mt-4">
        @forelse ($favorites as $property)
            <div class="col-md-6 mb-4">
                <!-- Кликабельная карточка -->
                <div class="card property-card h-100" onclick="window.location='{{ route('properties.show', $property->id) }}'">
                    <!-- Изображение -->
                    <div class="card-img-container">
                        <img src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/300x200' }}"
                             class="card-img-top primary-img"
                             alt="{{ $property->title }}">
                        <!-- Кнопка избранного -->
                        <div class="card-footer-button"
                             style="position: absolute; top: 12px; right: 12px; z-index: 10;"
                             onclick="event.stopPropagation();">
                            <form action="{{ route('favorites.toggle', $property->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="favorite-icons {{ auth()->user()->favorites->contains($property->id) ? 'favorite-added' : '' }}"
                                        title="Убрать из избранного"
                                        style="border: none; background: none; cursor: pointer;">
                                    <i class="bi bi-heart"></i>
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="card-body-content flex-grow-1">
                            <p class="modal-property-title">
                                {{ $sliders->firstWhere('id', $property->slider_id)->title ?? $property->title }}
                            </p>
                            <h5 class="card-title fst-italic pt-2">{{ $property->title }}</h5>
                            <p class="card-text text-muted small m-0">
                                @if($property->price > 0)
                                    Цена: <strong>{{ number_format($property->price, 0, '.', ' ') }} ₽</strong><br>
                                @else
                                    Цена: <strong><a href="{{ route('consultation') }}" class="btn btn-light btn-sm">Узнать цену</a></strong><br>
                                @endif
                                @if($property->area) Площадь: {{ $property->area }} м²<br> @endif
                                @if($property->rooms) Комнат: {{ $property->rooms }}<br> @endif
                                @if($property->type) Тип: {{ $property->type }}<br> @endif
                                <small>{{ $property->address ?? 'Не указан' }}</small>
                            </p>
                        </div>
                        <!-- Форма заявки -->
                        <form action="{{ route('purchase-requests.store', $property->id) }}" method="POST" class="mt-3" onclick="event.stopPropagation();">
                            @csrf
                            <textarea style="resize: none;" name="comment" class="form-control form-control-sm mb-2" rows="3" placeholder="Комментарий к заявке (необязательно)"></textarea>
                            <button type="submit" class="btn btn-sm sub-btn w-100">Отправить заявку</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">У вас пока нет избранных объектов.</p>
            </div>
        @endforelse
    </div>
</div>