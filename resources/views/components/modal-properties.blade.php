<div class="modal-properties mt-4">
    <h5 class="modal-properties-title">Новые ЖК</h5>
    @if ($sliders->isEmpty())
        <p class="text-muted">ЖК пока не добавлены.</p>
    @else
        <div class="modal-properties-grid">
            @foreach ($sliders as $slider)
                <div class="modal-property-card" onclick="window.location='{{ route('sliders.show', $slider->id) }}'">
                    <div class="modal-property-img-container">
                        <img src="{{ $slider->image_path ? asset('storage/' . $slider->image_path) : 'https://via.placeholder.com/150x100' }}"
                             alt="{{ $slider->title }}"
                             class="modal-property-img">
                    </div>
                    <div class="modal-property-body">
                        <h6 class="modal-property-title d-flex justify-content-center">{{ Str::limit($slider->title, 20) }}</h6>
                        <p class="modal-property-price d-flex justify-content-center p-2">
                            @if($slider->price > 0)
                                <strong>Цена: {{ number_format($slider->price, 0, ' ', ' ') }} ₽</strong>
                            @else
                                @auth
                                    <a href="{{ url('properties?type=&slider_id=' . $slider->id) }}"
                                       class="btn btn-outline-secondary"
                                       >Подробнее</a>
                                @endauth
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>