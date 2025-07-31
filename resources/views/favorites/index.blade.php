<!-- resources/views/favorites/index.blade.php -->

<div class="depth-card" style="background: #ffffff; border-radius: 12px; border: 1px solid #e9ecef; padding: 25px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
    <h4>Избранные объекты</h4>
    <div class="row">
        @forelse ($favorites as $property)
            <div class="col-md-4 mb-4">
                <!-- Кликабельная карточка -->
                <div class="card property-card"
                     onclick="window.location='{{ route('properties.show', $property->id) }}'"
                     style="cursor: pointer; transition: transform 0.2s; border: 1px solid #e9ecef;">
                    
                    <img src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/300x200' }}"
                         class="card-img-top"
                         alt="{{ $property->title }}"
                         style="height: 200px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="card-title">{{ $property->title }}</h5>
                        <p class="card-text text-muted small">
                            Цена: <strong>{{ number_format($property->price, 0, '.', ' ') }} ₽</strong><br>
                            @if($property->area) Площадь: {{ $property->area }} м²<br> @endif
                            @if($property->rooms) Комнат: {{ $property->rooms }}<br> @endif
                            @if($property->type) Тип: {{ $property->type }}<br> @endif
                            <small>{{ $property->address ?? 'Не указан' }}</small>
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('properties.show', $property->id) }}"
                               class="btn btn-sm btn-primary"
                               onclick="event.stopPropagation();">
                                Подробнее
                            </a>
                            <form action="{{ route('favorites.toggle', $property->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="event.stopPropagation();">
                                    Убрать
                                </button>
                            </form>
                        </div>
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