<div class="tab-pane fade p-4" id="properties" role="tabpanel" aria-labelledby="properties-tab">
    <h5 class="card-title text-xl font-semibold mb-3">Управление объектами недвижимости</h5>
    <a href="{{ route('dashboard.properties.create') }}" class="btn btn-primary mb-3">Добавить объект</a>
    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover dashboard-table">
            <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Адрес</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Изображение</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($properties as $property)
                    <tr class="align-middle">
                        <td>{{ $property->title ?: '-' }}</td>
                        <td>{{ $property->address ?: '-' }}</td>
                        <td>{{ number_format($property->price, 0, ',', ' ') }} ₽</td>
                        <td>
                            @if ($property->image_path)
                                <img src="{{ asset('storage/' . $property->image_path) }}" alt="{{ $property->title }}" class="img-thumbnail dashboard-img-thumbnail">
                            @else
                                <span class="text-muted">Нет изображения</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('dashboard.properties.edit', $property) }}" class="btn btn-warning btn-sm text-white dashboard-btn-warning">Редактировать</a>
                                <form action="{{ route('dashboard.properties.destroy', $property) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm text-white dashboard-btn-danger">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Объектов нет. Добавьте новый!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-container">
        @if ($properties->hasPages())
            {{ $properties->appends(['tab' => 'properties'])->links('pagination::bootstrap-5') }}
        @endif
    </div>
</div>