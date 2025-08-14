<div class="tab-pane fade p-4" id="purchase-requests" role="tabpanel" aria-labelledby="purchase-requests-tab">
    <h5 class="card-title text-xl font-semibold mb-3">Заявки на покупку</h5>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 dashboard-alert-success" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover dashboard-table">
            <thead>
                <tr>
                    <th scope="col">Пользователь</th>
                    <th scope="col">Объект</th>
                    <th scope="col">Комментарий</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchaseRequests as $request)
                    <tr class="align-middle">
                        <td>{{ $request->user->name ?: '-' }}</td>
                        <td>{{ $request->property->title ?: '-' }}</td>
                        <td>{{ $request->comment ?: '-' }}</td>
                        <td>{{ $request->status === 'pending' ? 'Ожидает' : ($request->status === 'approved' ? 'Одобрено' : 'Отклонено') }}</td>
                        <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <form action="{{ route('dashboard.purchase-requests.destroy', $request) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить заявку?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm text-white dashboard-btn-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3 text-white">Заявок на покупку нет.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            @if ($purchaseRequests->hasPages())
                {{ $purchaseRequests->appends(['tab' => 'purchase-requests'])->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
</div>