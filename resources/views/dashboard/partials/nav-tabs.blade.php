<ul class="nav nav-tabs mb-4 dashboard-nav-tabs" id="adminTabs" role="tablist">
    @foreach([
        ['id' => 'home', 'label' => 'Главная страница', 'active' => true],
        ['id' => 'properties', 'label' => 'Объекты', 'active' => false],
        ['id' => 'contacts', 'label' => 'Заявки', 'active' => false],
        ['id' => 'purchase-requests', 'label' => 'Заявки на покупку', 'active' => false],
        ['id' => 'telephone', 'label' => 'Телефон', 'active' => false],
        ['id' => 'email', 'label' => 'Email', 'active' => false],
        ['id' => 'banner', 'label' => 'Баннер', 'active' => false]
    ] as $tab)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $tab['active'] ? 'active' : '' }}"
                    id="{{ $tab['id'] }}-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#{{ $tab['id'] }}"
                    type="button"
                    role="tab"
                    aria-controls="{{ $tab['id'] }}"
                    aria-selected="{{ $tab['active'] ? 'true' : 'false' }}">
                {{ $tab['label'] }}
            </button>
        </li>
    @endforeach
</ul>