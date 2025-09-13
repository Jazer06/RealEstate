@extends('layouts.app')

@section('carousel')
        <div class="video-background">
            <video autoplay loop muted playsinline>
                <source src="{{ asset('storage/banner-image/video.webm') }}" type="video/webm">
                Ваш браузер не поддерживает видео.
            </video>
            <div class="gradient-overlay"></div>
            <div class="content-overlay">
                <h1>Sofiarealty</h1>
                <p>Продажа квартир в новостройках — просто, быстро, надёжно</p>
            </div>
        </div>

<style>

</style>
@if (session('success'))
    <div class="alert alert-success mb-4 text-center mt-5">
        {{ session('success') }}
    </div>
@endif
@endsection


@section('content')
<div style="margin-top: -100px;">
    @include('components.filters')
</div>


@include('components.property-list', ['properties' => $properties])

@if($totalProperties === 0)
    <div class="alert alert-warning mt-4">
        По вашему запросу ничего не найдено.
    </div>
@endif

@include('components.banner')
@include('components.contacts-form')
@endsection
