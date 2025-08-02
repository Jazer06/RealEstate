<div class="tab-pane fade p-4" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
    <h5 class="card-title text-xl font-semibold mb-3">Управление заявками</h5>
    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover dashboard-table">
            <thead>
                <tr>
                    <th scope="col">Имя</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr class="align-middle">
                        <td>{{ $contact->name ?: '-' }}</td>
                        <td>{{ $contact->phone ?: '-' }}</td>
                        <td>{{ $contact->description ?: '-' }}</td>
                        <td>{{ $contact->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <form action="{{ route('dashboard.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить заявку?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm text-white dashboard-btn-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Заявок нет.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-container">
            @if ($contacts->hasPages())
                {{ $contacts->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
</div>