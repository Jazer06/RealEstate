<div class="mt-6 mb-3">
    <div class="mt-6 glass-effect-banner">
        <div class="row">
            <div class="col-12 col-md-6">
                <p class="text-highlight">
                    <strong>{{ $bannerTitle }}</strong>
                </p>
            </div>
            <div class="col-12 col-md-6">
                <p class="text-description">
                    {{ $bannerDescription }}
                </p>
            </div>
        </div>
        <div class="row gallery-grid">
            <div class="col-12 col-md-3 mb-4">
                <img src="{{ asset('storage/banner-image/imge1.webp') }}" 
                     alt="Изображение 1" 
                     class="gallery-image-banner gallery-image-1 hover-scale-banner">
            </div>
            <div class="col-12 col-md-3 mb-4 d-none d-md-block">
                <img src="{{ asset('storage/banner-image/imge2.webp') }}" 
                     alt="Изображение 2" 
                     class="gallery-image-banner gallery-image-2 hover-scale-banner">
            </div>
            <div class="col-12 col-md-3 offset-md-6 gallery-offset-banner d-none d-md-block">
                <img src="{{ asset('storage/banner-image/imge3.webp') }}" 
                     alt="Изображение 3" 
                     class="gallery-image-banner gallery-image-3 hover-scale-banner">
            </div>
            <div class="col-12 col-md-3 gallery-offset-banner">
                <img src="{{ asset('storage/banner-image/imge4.webp') }}" 
                     alt="Изображение 4" 
                     class="gallery-image-banner gallery-image-4 hover-scale-banner">
            </div>
        </div>
    </div>
</div>