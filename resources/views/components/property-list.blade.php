<style>
    .cyber-title {
        font-size: 35px;
        text-transform: uppercase;
        color: black;
        text-align: center;
        letter-spacing: 3px;
        margin: 20px 0 40px;
    }

    .void-module * {
        position: relative;
        z-index: 1;
    }

    .void-slab {
        margin-bottom: 30px;
        transform: perspective(800px);
        transform-style: preserve-3d;
        cursor: pointer;
    }

    .void-slab:hover .void-module {
        transform: translateY(0);
    }

    .void-slab:hover .void-module p {
        opacity: 1;
    }

    .void-slab:hover .void-module,
    .void-slab:hover .void-module p {
        transition: 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .void-slab:hover .void-module:after {
        transition: 3s cubic-bezier(0.23, 1, 0.32, 1);
        opacity: 1;
        transform: translateY(0);
    }

    .void-slab:hover .void-backdrop {
        transition: 0.6s cubic-bezier(0.23, 1, 0.32, 1), opacity 3s cubic-bezier(0.23, 1, 0.32, 1);
        opacity: 0.85;
    }

    .void-slab:hover .void-core {
        transition: 0.6s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 1.5s cubic-bezier(0.23, 1, 0.32, 1);
        box-shadow: rgba(255, 255, 255, 0.15) 0 0 25px 2px, rgba(0, 0, 0, 0.5) 0 15px 40px;
    }

    .void-core {
        position: relative;
        width: 100%;
        height: 450px;
        background-color: #1a1a1a;
        overflow: hidden;
        border-radius: 16px;
        box-shadow: rgba(0, 0, 0, 0.7) 0 25px 50px -12px, inset #222 0 0 0 4px, inset rgba(255, 255, 255, 0.2) 0 0 0 5px;
        transition: 0.8s cubic-bezier(0.445, 0.05, 0.55, 0.95);
    }

    .void-backdrop {
        opacity: 0.5;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        transition: 0.8s cubic-bezier(0.445, 0.05, 0.55, 0.95), opacity 3s cubic-bezier(0.445, 0.05, 0.55, 0.95);
        pointer-events: none;
    }

    .void-module {
        padding: 30px;
        position: absolute;
        bottom: 0;
        width: 100%;
        color: #fff;
        transform: translateY(60%);
        transition: 0.6s 0.8s cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    .void-module p {
        opacity: 0;
        max-height: 130px;
        overflow-y: auto;
        font-size: 15px;
        line-height: 1.5;
        margin: 0 0 20px;
        text-shadow: rgba(0, 0, 0, 0.8) 0 3px 5px;
        transition: 0.6s 0.8s cubic-bezier(0.215, 0.61, 0.355, 1);
    }

    /* Кастомный скролл */
    .void-module p::-webkit-scrollbar {
        width: 8px;
    }
    .void-module p::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.25);
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: padding-box;
    }

    .void-module:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.8) 90%);
        opacity: 0;
        transform: translateY(110%);
        transition: 3s cubic-bezier(0.445, 0.05, 0.55, 0.95);
    }

    .void-module h1 {
        font-size: 26px;
        font-weight: 800;
        margin: 0 0 15px;
        letter-spacing: 1px;
        text-shadow: rgba(0, 0, 0, 0.7) 0 5px 12px;
    }

    /* Кнопка */
    .cyber-btn {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
    }
    .cyber-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

}
</style>

<div class="container-obj">
    <div class="container">
        <div class="grid-row row">
            <div class="row d-flex">
                <div class="col-md-4 mt-3"> <hr></div>
                <div class="col-md-4"><h1 class="cyber-title">Наши ЖК</h1></div>
                <div class="col-md-4 mt-3"> <hr></div>
            </div>
          
          

            @foreach($sliders as $slider)
                @php
                    $imageUrl = $slider->image_path
                        ? asset('storage/' . $slider->image_path)
                        : 'https://via.placeholder.com/350x450';
                @endphp

                <div class="col-md-4 d-flex justify-content-center mb-4">
                    <div class="void-slab w-100">
                        <div class="void-core">
                            <div class="void-backdrop" style="background-image: url('{{ $imageUrl }}');"></div>
                            <div class="void-module">
                                <h1>{{ $slider->title }}</h1>
                                <p>{{ $slider->description ?? 'Описание отсутствует' }}</p>
                                @if($slider->button_text && $slider->button_link)
                                <a href="{{ $slider->button_link }}" class="btn  btn-sm adress-span-card">
                                        {{ $slider->button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mb-3">
            <hr>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const tiltElements = document.querySelectorAll(".void-core");
    if (tiltElements.length) {
        VanillaTilt.init(tiltElements, {
            glare: true,
            "max-glare": 0.25,
            max: 8,
            speed: 500,
            scale: 1.02,
            gyroscope: true
        });
    }
});
</script>