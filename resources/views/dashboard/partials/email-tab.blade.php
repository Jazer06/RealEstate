<div class="tab-pane fade p-4" id="email" role="tabpanel" aria-labelledby="email-tab">
    <h5 class="card-title text-xl font-semibold mb-3">Смена почты на сайте</h5>
    <p>При клике на поле показывается старая почта.</p>
    <form method="POST" action="{{ route('dashboard.email.update') }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="email" class="form-label">Электронная почта</label>
            <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $email ?? 'group.ru') }}" placeholder="example@email.com">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary dashboard-btn-primary">Сохранить почту</button>
    </form>
</div>