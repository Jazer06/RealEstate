@extends('layouts.app')

@section('content')
<div class="container mt-6">
    <div class="row">
        <div class="col-md-4">
            <div class="depth-card">
                <div class="card-body text-center">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="avatarForm" class="avatar-form">
                        @csrf
                        @method('PUT')
                        <div class="avatar-container" style="position: relative; display: inline-block;">
                            @if (auth()->user()->avatar)
                              <div class="avatar-wrapper">
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ auth()->user()->name }}" class="rounded-circle avatar-img" style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;" onclick="document.getElementById('avatarInput').click();">
                              </div>
                            @else
                                <div class="avatar-wrapper" style="cursor: pointer;" onclick="document.getElementById('avatarInput').click();">
                                    <div style="height: 150px; width: 150px; background: linear-gradient(145deg, #6a0dad, #4b0082); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <span style="font-size: 3rem; color: white; font-weight: bold;">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                </div>
                            @endif
                            <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none" onchange="this.form.submit();">
                            @error('avatar')
                                <span class="invalid-feedback d-block text-center">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                    <h2 class="card-title" style="color: #333; margin-bottom: 0.5rem; font-weight: 600; margin-top: 1.5rem;">{{ auth()->user()->name }}</h2>
                    <button type="button" class="btn profile-btn mt-3" data-bs-toggle="modal" data-bs-target="#profileSettingsModal">
                        ⚙️ Настройки профиля
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="info-card depth-card">
                <div class="card-body">
                    <h3 class="card-title" style="color: #333; margin-bottom: 1.5rem; font-weight: 600;">Контактная информация</h3>
                    <ul class="list-group list-group-flush" style="border: none;">
                        <li class="list-group-item" style="padding: 1rem 0; border: none; background: transparent;">
                            <strong style="color: #4b0082;">Email:</strong> 
                            <span style="color: #666; margin-left: 10px;">{{ auth()->user()->email }}</span>
                        </li>
                        <li class="list-group-item" style="padding: 1rem 0; border: none; background: transparent;">
                            <strong style="color: #4b0082;">Телефон:</strong> 
                            <span style="color: #666; margin-left: 10px;">
                                {{ auth()->user()->phone ? '+7 (' . substr(auth()->user()->phone, 2, 3) . ') ' . substr(auth()->user()->phone, 5, 3) . '-' . substr(auth()->user()->phone, 8, 2) . '-' . substr(auth()->user()->phone, 10, 2) : 'Не указан' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection