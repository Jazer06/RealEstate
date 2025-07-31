<style>
    .property-card {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }

    .property-card:hover {
        transform: translateY(-1px);
    }

    .property-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #d8bfd8, #9370db, #d8bfd8);
        border-radius: 0 0 20px 20px;
        opacity: 0.6;
    }

    .property-card .card-img-container {
        height: 356px;
        position: relative;
        overflow: hidden;
        border-radius: 12px 12px 0 0;
        display: flex;
    }

    .property-card .card-img-container img.primary-img {
        position: absolute !important;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        object-fit: cover;
        object-position: center;
        color: transparent;
        z-index: 2;
        transition: width 0.3s ease;
    }

    .property-card .card-img-container img.secondary-img {
        position: absolute !important;
        top: 0;
        right: 0;
        height: 100%;
        width: 0;
        border-bottom-right-radius: 15px;
        object-fit: cover;
        object-position: center;
        color: transparent;
        z-index: 1;
        transition: width 0.3s ease;
    }

    .property-card:has(.card-img-container img.secondary-img):hover .card-img-container img.primary-img {
        width: 60%;
    }

    .property-card:has(.card-img-container img.secondary-img):hover .card-img-container img.secondary-img {
        width: 50%;
    }

    .property-card .card-body {
        flex: 1;
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .favorite-icon {
        position: relative;
        border: none;
        background: transparent;
        transition: all 0.3s ease;
    }

    .favorite-added {
        background-color: #e74c3c !important;
        color: #fff !important;
        border-radius: 12px;
        padding: 5px;
    }

    .favorite-added .bi-heart {
        display: none;
    }
</style>

<div class="row">
    @forelse ($properties as $property)
        <div class="col-sm-12 mb-4">
            <div class="card property-card" onclick="window.location='{{ route('properties.show', $property->id) }}'">
                <div class="card-img-container">
                    <img class="primary-img" src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/300x200' }}" 
                         alt="{{ $property->title }}">
                    @if ($property->images()->where('is_plan', true)->first())
                        <img class="secondary-img" src="{{ asset('storage/' . $property->images()->where('is_plan', true)->first()->image_path) }}" 
                             alt="{{ $property->title }} - план дома">
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="card-title fst-italic pt-2">{{ $property->title }}</h5> 
                        </div>
                        <div class="col-sm-6">
                            <p class="card-text fst-italic pt-2">
                                @if($property->type){{ $property->type }}<br> @endif
                                Адрес: {{ $property->address ?? 'Не указан' }}
                            </p>
                            <p>{{ $property->description ?? 'Нет описания' }}</p>                            
                        </div>
                        <div class="d-flex justify-content-end p-2">
                            @auth
                                <form action="{{ route('favorites.toggle', $property->id) }}" method="POST" onclick="event.stopPropagation();">
                                    @csrf
                                    <button type="submit" class="p-2 favorite-icon {{ auth()->user()->favorites->contains($property->id) ? 'favorite-added' : '' }}">
                                        <i class="bi bi-heart"></i>
                                        @if (auth()->user()->favorites->contains($property->id))
                                            <i class="bi bi-x-lg"></i>
                                        @endif
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>Недвижимость не найдена.</p>
    @endforelse
</div>


<div class="pagination-container">
    @if ($properties->hasPages())
        {{ $properties->links('pagination::bootstrap-5') }}
    @else
        <p class="text-light text-center">Нет страниц для пагинации.</p>
    @endif
</div>
