
document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.custom-slide');
    const thumbContainers = document.querySelectorAll('.thumb-container');

    // Все фото
    const galleryImages = Array.from(slides).map(slide => ({
        src: slide.querySelector('img').src,
        alt: slide.querySelector('img').alt,
        type: slide.dataset.type
    }));

    if (galleryImages.length === 0) return;

    // Создаём полноэкранное окно
    const overlay = document.createElement('div');
    overlay.classList.add('fullscreen-overlay');
    overlay.innerHTML = `
        <span class="fullscreen-close">&times;</span>
        <img src="" alt="" class="fullscreen-image">
        <div class="fullscreen-counter">1 из ${galleryImages.length}</div>
        <div class="fullscreen-thumbnails"></div>
    `;
    document.body.appendChild(overlay);

    const fullscreenImg = overlay.querySelector('.fullscreen-image');
    const closeBtn = overlay.querySelector('.fullscreen-close');
    const counter = overlay.querySelector('.fullscreen-counter');
    const thumbnailsContainer = overlay.querySelector('.fullscreen-thumbnails');

    let currentIndex = 0;
    let touchStartX = 0;
    let touchEndX = 0;
    const minSwipeDistance = 50;

    // Создаём миниатюры в полноэкранном режиме
    galleryImages.forEach((img, index) => {
        const thumb = document.createElement('div');
        thumb.classList.add('fullscreen-thumb');
        thumb.style.backgroundImage = `url('${img.src}')`;
        thumb.dataset.index = index;
        thumb.addEventListener('click', () => {
            currentIndex = parseInt(index);
            fullscreenImg.src = img.src;
            fullscreenImg.alt = img.alt;
            updateActiveThumb();
            counter.textContent = `${currentIndex + 1} из ${galleryImages.length}`;
        });
        thumbnailsContainer.appendChild(thumb);
    });

    const fullscreenThumbs = document.querySelectorAll('.fullscreen-thumb');

    function updateActiveThumb() {
        fullscreenThumbs.forEach(t => t.classList.remove('active'));
        if (fullscreenThumbs[currentIndex]) {
            fullscreenThumbs[currentIndex].classList.add('active');
            // Прокрутка к активной
            fullscreenThumbs[currentIndex].scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }
    }

    // Открытие по клику на фото
    slides.forEach((slide, index) => {
        const img = slide.querySelector('img');
        img.addEventListener('click', () => {
            currentIndex = index;
            fullscreenImg.src = galleryImages[currentIndex].src;
            fullscreenImg.alt = galleryImages[currentIndex].alt;
            counter.textContent = `${currentIndex + 1} из ${galleryImages.length}`;
            updateActiveThumb();
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Закрытие
    function closeFullscreen() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        setTimeout(() => {
            fullscreenImg.src = '';
        }, 300);
    }

    closeBtn.addEventListener('click', closeFullscreen);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay || e.target === closeBtn) {
            closeFullscreen();
        }
    });

    // Листание мышью (влево/вправо)
    overlay.addEventListener('click', (e) => {
        if (e.target !== overlay && e.target !== fullscreenImg && e.target !== closeBtn) return;
        const rect = overlay.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        if (clickX < rect.width / 2) {
            currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
        } else {
            currentIndex = (currentIndex + 1) % galleryImages.length;
        }
        fullscreenImg.src = galleryImages[currentIndex].src;
        updateActiveThumb();
        counter.textContent = `${currentIndex + 1} из ${galleryImages.length}`;
    });

    // Свайп
    overlay.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    overlay.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });

    function handleSwipe() {
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) < minSwipeDistance) return;
        if (diff > 0) {
            currentIndex = (currentIndex + 1) % galleryImages.length;
        } else {
            currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
        }
        fullscreenImg.src = galleryImages[currentIndex].src;
        updateActiveThumb();
        counter.textContent = `${currentIndex + 1} из ${galleryImages.length}`;
    }

    // Клавиатура
    document.addEventListener('keydown', (e) => {
        if (!overlay.classList.contains('active')) return;
        if (e.key === 'Escape') {
            closeFullscreen();
        } else if (e.key === 'ArrowLeft') {
            currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
            fullscreenImg.src = galleryImages[currentIndex].src;
            updateActiveThumb();
            counter.textContent = `${currentIndex + 1} из ${galleryImages.length}`;
        } else if (e.key === 'ArrowRight') {
            currentIndex = (currentIndex + 1) % galleryImages.length;
            fullscreenImg.src = galleryImages[currentIndex].src;
            updateActiveThumb();
            counter.textContent = `${currentIndex + 1} из ${galleryImages.length}`;
        }
    });

    // Навигация по миниатюрам
    thumbContainers.forEach(container => {
        container.addEventListener('click', function () {
            const index = this.dataset.index;

            // Обновляем большой слайд
            document.querySelector('.custom-slide.active')?.classList.remove('active');
            const targetSlide = document.querySelector(`.custom-slide[data-index="${index}"]`);
            if (targetSlide) targetSlide.classList.add('active');

            // Обновляем миниатюры
            document.querySelector('.thumb-container.active')?.classList.remove('active');
            this.classList.add('active');

            // Обновляем индекс
            currentIndex = parseInt(index);
        });
    });
});
