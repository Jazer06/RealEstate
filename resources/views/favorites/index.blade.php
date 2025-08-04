<!-- Контейнер для избранных объектов -->
<div class="depth-card" style="background: #ffffff; border-radius: 12px; border: 1px solid #e9ecef; padding: 25px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
    <h4>Избранные объекты</h4>
    <div class="row">
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
                             style="position: absolute; top: 12px; right: 12px; padding: 15px; z-index: 10;"
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
                    <!-- Тело карточки -->
                    <div class="card-body d-flex flex-column">
                        <div class="card-body-content flex-grow-1">
                            <h5 class="card-title fst-italic pt-2">{{ $property->title }}</h5>
                            <p class="card-text text-muted small m-0">
                                Цена: <strong>{{ number_format($property->price, 0, '.', ' ') }} ₽</strong><br>
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

<!-- Уведомления -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
<style>
    
</style>