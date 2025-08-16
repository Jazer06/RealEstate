<div class="table-responsive">
    <table class="table table-dark table-striped table-hover dashboard-table">
        <thead>
            <tr>
                <th scope="col">Название</th>
                <th scope="col">Заголовок</th>
                <th scope="col">Подпись</th>
                <th scope="col">Текст кнопки</th>
                <th scope="col">Ссылка</th>
                <th scope="col">Изображение</th>
                <th scope="col">Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sliders as $slider)
                <tr class="align-middle">
                    <td>Слайд {{ $loop->index + 1 }}</td>
                    <td>{{ $slider->title ?: '-' }}</td>
                    <td>{{ $slider->subtitle ?: '-' }}</td>
                    <td>{{ $slider->button_text ?: '-' }}</td>
                    <td>{{ $slider->button_link ?: '-' }}</td>
                    <td>
                        @if ($slider->image_path)
                            <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}" class="img-thumbnail dashboard-img-thumbnail">
                        @else
                            <span class="text-white">Нет изображения</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('dashboard.sliders.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Вы уверены?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm text-white dashboard-btn-danger">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">Слайдеров нет. Добавьте новый!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Пагинация -->
<div class="pagination-container">
    @if ($sliders instanceof \Illuminate\Pagination\Paginator || $sliders instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @if ($sliders->hasPages())
            {{ $sliders->links('pagination::bootstrap-5') }}
        @endif
    @endif
</div>