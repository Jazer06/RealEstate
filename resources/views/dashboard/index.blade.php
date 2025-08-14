@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<body class="dashboard-page">
    <div class="container mt-6">
        <div class="dashboard-container py-4 mt-6">
            <h1 class="text-3xl font-bold mb-4">Админ-панель</h1>
            <ul class="nav nav-tabs mb-4 dashboard-nav-tabs" id="adminTabs" role="tablist">
                @foreach([
                    ['id' => 'home', 'label' => 'Главная страница'],
                    ['id' => 'properties', 'label' => 'Объекты'],
                    ['id' => 'contacts', 'label' => 'Заявки'],
                    ['id' => 'purchase-requests', 'label' => 'Заявки на покупку'],
                    ['id' => 'telephone', 'label' => 'Телефон'],
                    ['id' => 'email', 'label' => 'Email'],
                    ['id' => 'banner', 'label' => 'Баннер']
                ] as $tab)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link"
                                id="{{ $tab['id'] }}-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#{{ $tab['id'] }}"
                                type="button"
                                role="tab"
                                aria-controls="{{ $tab['id'] }}"
                                aria-selected="false">
                            {{ $tab['label'] }}
                        </button>
                    </li>
                @endforeach
            </ul>
            
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
</body>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentTab = urlParams.get('tab') || 'home';

    function setActiveTab(tabId) {
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.classList.remove('active');
            tab.setAttribute('aria-selected', 'false');
        });
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        
        const tabElement = document.querySelector(`[data-bs-target="#${tabId}"]`);
        if (tabElement) {
            tabElement.classList.add('active');
            tabElement.setAttribute('aria-selected', 'true');
            document.getElementById(tabId).classList.add('show', 'active');
        }
    }
    
    setActiveTab(currentTab);
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const targetTab = this.getAttribute('data-bs-target').substring(1);
            const url = new URL(window.location);

            url.searchParams.set('tab', targetTab);
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        });
    });
    window.addEventListener('popstate', function() {
        const tabParam = new URLSearchParams(window.location.search).get('tab') || 'home';
        setActiveTab(tabParam);
    });
});
</script>
@endsection