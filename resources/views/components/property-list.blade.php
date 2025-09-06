<div class="mt-6">
    <div class="container">
        <div class="row">
            @forelse ($properties as $property)
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
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
                                        <p class="m-0" style="padding-top: 10px;">
                                            @if($property->area)
                                                <strong>м²</strong> {{ number_format($property->area, 1, ',', ' ') }}
                                            @endif
                                        </p>
                                        @if(!empty($property->address) && $property->address !== 'Адрес не указан')
                                        <p class="m-0" style="padding-top: 10px;">
                                                <strong>Адрес:</strong> {{ $property->address }}
                                        </p>
                                        @endif
                                        <p class="card-text mb-2" style="padding-top:10px">
                                            @if($property->price > 0)
                                                <strong> Цена:{{ number_format($property->price, 0, ' ', ' ') }} ₽</strong>
                                            @else
                                                <strong>Цена: <a href="{{ route('consultation') }}" class="btn btn-outline-secondary">Узнать цену</a></strong>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <p class="card-description p-2">
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

<div class="pagination-container">
    @if ($properties->hasPages())
        {{ $properties->links('pagination::bootstrap-5') }}
    @endif
</div>