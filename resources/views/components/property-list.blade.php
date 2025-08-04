<div class="mt-6">
    <div class="row">
        @forelse ($properties as $property)
            <div class="{{ $loop->first ? 'col-12' : 'col-6' }} mb-4">
        <div class="card property-card h-100" onclick="window.location='{{ route('properties.show', $property->id) }}'">
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
                             style="position: absolute; top: 12px; right: 12px; padding: 15px; z-index: 10;"
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
                <div class="card-body d-flex flex-column">
                    <div class="card-body-content flex-grow-1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5 class="card-title fst-italic pt-2">{{ $property->title }}</h5>
                                </div>
                                <div class="col-sm-6">
                                    <p class="card-text pt-2 m-0">
                                        <strong>От: {{ number_format($property->price, 0, ' ', ' ') }} ₽</strong><br>
                                    </p>
                                    <p class="m-0">
                                        @if($property->area)
                                            <strong>м²</strong> {{ number_format($property->area, 1, ',', ' ') }}
                                        @endif
                                    </p>
                                    <p class="m-0">
                                        <strong>Адрес:</strong> {{ $property->address ?? '' }}
                                    </p>
                                    <p class="card-description">
                                        {{ $property->description ?? '' }}
                                    </p>
                                </div>
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

<div class="pagination-container">
    @if ($properties->hasPages())
        {{ $properties->links('pagination::bootstrap-5') }}
    @endif
</div>