
<div class="tab-pane fade p-4" id="telephone" role="tabpanel" aria-labelledby="telephone-tab">
    <h5 class="card-title text-xl font-semibold mb-3">Смена телефона на сайте</h5>
    <p>При клике на поле показывается старый.</p>
    <form method="POST" action="{{ route('dashboard.phone.update') }}" class="mb-4">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="phone_number" class="form-label">Номер телефона</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $phoneNumber ?? '+7 (953) 555-33-32') }}" placeholder="+7(XXX)-XXX-XX-XX">
            @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary dashboard-btn-primary">Сохранить телефон</button>
    </form>
</div>