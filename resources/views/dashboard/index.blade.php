@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <div class="container mt-6">
        <div class="dashboard-container py-4 mt-6">
            <h1 class="text-3xl font-bold mb-4">Админ-панель</h1>
            <p class="mb-4">Добро пожаловать, {{ Auth::user()->name }}!</p>

            @include('dashboard.partials.nav-tabs')

            <div class="tab-content dashboard-tab-content" id="adminTabsContent">
                @include('dashboard.partials.home-tab')
                @include('dashboard.partials.properties-tab')
                @include('dashboard.partials.contacts-tab')
                @include('dashboard.partials.purchase-requests-tab', ['purchaseRequests' => $purchaseRequests])

                @include('dashboard.partials.telephone-tab')
                @include('dashboard.partials.email-tab')
                @include('dashboard.partials.banner-tab')
            </div>
        </div>
    </div>
@endsection