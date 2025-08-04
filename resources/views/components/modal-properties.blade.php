<div class="modal-properties mt-4">
    <h5 class="modal-properties-title">Новые объекты</h5>
    @if ($properties->isEmpty())
        <p class="text-muted">Объекты пока не добавлены.</p>
    @else
        <div class="modal-properties-grid">
            @foreach ($properties as $property)
                <div class="modal-property-card" onclick="window.location='{{ route('properties.show', $property->id) }}'">
                    <div class="modal-property-img-container">
                        <img src="{{ $property->image_path ? asset('storage/' . $property->image_path) : 'https://via.placeholder.com/150x100' }}"
                             alt="{{ $property->title }}"
                             class="modal-property-img">
                    </div>
                    <div class="modal-property-body">
                        <h6 class="modal-property-title">{{ Str::limit($property->title, 20) }}</h6>
                        <p class="modal-property-price">От: {{ number_format($property->price, 0, ' ', ' ') }} ₽</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>