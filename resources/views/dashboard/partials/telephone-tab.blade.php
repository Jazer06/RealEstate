<div class="tab-pane fade p-4" id="telephone" role="tabpanel" aria-labelledby="telephone-tab">
    <h5 class="card-title text-xl font-semibold mb-3">Смена телефона на сайте</h5>
    <p>При клике на поле показывается старый.</p>

    @if(session('success'))
        <div class="dashboard-alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('dashboard.phone.update') }}" class="mb-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="phone_number" class="form-label">Номер телефона</label>
            <input type="text" name="phone_number" id="phone_number" 
                   class="form-control"
                   value="{{ old('phone_number', $phoneNumber) }}"
                   placeholder="+7(XXX)-XXX-XX-XX">
            @error('phone_number') 
                <span class="text-danger">{{ $message }}</span> 
            @enderror
        </div>

        <button type="submit" class="btn btn-primary dashboard-btn-primary">Сохранить телефон</button>
    </form>
</div>
