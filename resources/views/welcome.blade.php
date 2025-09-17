@extends('layouts.app')

@section('carousel')
<div class="video-background">
    <video autoplay loop muted playsinline>
        <source src="{{ asset('storage/banner-image/video2.mp4') }}" type="video/webm">
        Ваш браузер не поддерживает видео.
    </video>
    <div class="gradient-overlay"></div>
    <div class="content-overlay ml-54">
        <p class="fs-1">Здесь начинаются перемены к лучшему!</p>
    </div>
</div>
@if (session('success'))
    <div class="alert alert-success mb-4 text-center mt-5">
        {{ session('success') }}
    </div>
@endif
@endsection

@section('content')
<div class="cards-mobile d-md-none" id="cards-mobile-container"></div>

@php
$cards = $sliders->map(function ($slider) {
    return [
        'title' => $slider->title,
        'desc'  => $slider->description ?? 'Описание отсутствует',
        'address' => $slider->adress, // Используем правильное имя поля address
        'image' => $slider->image_path
            ? asset('storage/' . $slider->image_path)
            : 'https://via.placeholder.com/320x180',
        'tags'  => ['центр', 'новостройка', 'комфорт'],
        'reverse' => false,
        'link'  => $slider->button_link ?? '#',
    ];
})->toArray();
@endphp
<script>
const cardsData = @json($cards);
const availableTags = [
    "ЖК", "центр", "новостройка", "комфорт", "паркинг",
    "с ремонтом", "вид на парк", "бизнес-класс", "ипотека", "уют"
];
const keywordMap = {
    "центр": ["центр", "метро", "площадь"],
    "новостройка": ["новый", "сдача", "строится"],
    "паркинг": ["парковка", "гараж"],
    "вид на парк": ["парк", "вид", "зеленый"],
    "комфорт+": ["уют", "комфорт", "евро"]
};

function getRandomTags(count = 3) {
    return availableTags
        .sort(() => Math.random() - 0.5)
        .slice(0, count);
}

function hashCode(str) {
    return str.split("").reduce((a, b) => ((a << 5) - a) + b.charCodeAt(0), 0);
}

function getStableTags(title, count = 3) {
    const tags = [];
    let seed = Math.abs(hashCode(title));
    for (let i = 0; i < count; i++) {
        tags.push(availableTags[seed % availableTags.length]);
        seed = Math.floor(seed / availableTags.length) || seed + 13;
    }
    return [...new Set(tags)];
}

function getTagsFromText(text) {
    let tags = [];
    for (let tag in keywordMap) {
        if (keywordMap[tag].some(word => text.toLowerCase().includes(word))) {
            tags.push(tag);
        }
    }
    return tags.length ? tags : ["ЖК"];
}

function getMixedTags(card, baseTags = ["ЖК"], randomCount = 2) {
    return [...new Set([...baseTags, ...getRandomTags(randomCount)])];
}

const tagMode = 'mixed';

cardsData.forEach(card => {
    switch(tagMode) {
        case 'random':
            card.tags = getRandomTags(3);
            break;
        case 'stable':
            card.tags = getStableTags(card.title, 3);
            break;
        case 'semantic':
            card.tags = getTagsFromText(card.title + " " + card.desc);
            break;
        case 'mixed':
            card.tags = getMixedTags(card);
            break;
        default:
            card.tags = ["ЖК"];
    }
});

// -----------------------------
// Рендер карточек
// -----------------------------
const cardsContainer = document.getElementById("cards-mobile-container");
document.documentElement.style.setProperty("--cards-mobile", cardsData.length);

function renderImage(card) {
    return `
        <div class="image-container">
            <img src="${card.image}" alt="${card.title}">
            <div class="info">
                <ul>${card.tags.map(t => `<li class="text">${t}</li>`).join("")}</ul>
            </div>
        </div>`;
}

function renderCard(card, index) {
    return `
        <div class="card-mobile ${card.reverse ? "reverse" : ""}" style="--index:${index+1}">
            <div class="card-mobile-content">
                ${card.reverse ? renderImage(card) : ""}
                <div class="header"><h2>${card.title}</h2></div>
                <div class="body">
                    <p class="mb-0 adress-span"><strong>Адрес:</strong> ${card.address || 'Адрес не указан'}</p>
                    <div class="description" data-state="collapsed">
                        <p>${card.desc}</p>
                    </div>
                    <button class="toggle-description">Показать ещё</button>
                </div>
                <div class="actions">
                    <a href="${card.link}" class="book-now">
                        Узнать больше
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"/>
                        </svg>
                    </a>
                </div>
                ${!card.reverse ? renderImage(card) : ""}
            </div>
        </div>`;
}

cardsContainer.innerHTML = cardsData.map(renderCard).join("");

// -----------------------------
// Обработчик для переключения описания и скрытия картинки
// -----------------------------
document.querySelectorAll('.toggle-description').forEach(button => {
    button.addEventListener('click', () => {
        const cardContent = button.closest('.card-mobile-content');
        const description = button.previousElementSibling; // Находим .description
        const imageContainer = cardContent.querySelector('.image-container');
        const isExpanded = description.classList.contains('expanded');

        if (isExpanded) {
            description.classList.remove('expanded');
            button.textContent = 'Показать ещё';
            button.classList.remove('expanded');
            description.dataset.state = 'collapsed';
            description.style.maxHeight = '4.5rem'; // Сбрасываем высоту до начальной
            if (imageContainer) {
                imageContainer.classList.remove('hidden'); // Показываем картинку
            }
        } else {
            description.classList.add('expanded');
            button.textContent = 'Скрыть';
            button.classList.add('expanded');
            description.dataset.state = 'expanded';
            description.style.maxHeight = `${description.scrollHeight}px`; // Динамическая высота
            if (imageContainer) {
                imageContainer.classList.add('hidden'); // Скрываем картинку
            }
        }
    });
});
</script>

<!-- <div class="d-none d-md-block" style="margin-top: -100px;">
    @include('components.filters')
</div> -->

<div class="d-none d-md-block">
    @include('components.property-list', ['sliders' => $sliders])  
</div>

@if($totalProperties === 0)
    <div class="alert alert-warning mt-4">
        По вашему запросу ничего не найдено.
    </div>
@endif

@include('components.banner')
@include('components.contacts-form')
@endsection