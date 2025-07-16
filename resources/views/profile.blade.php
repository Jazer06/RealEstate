@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Мой профиль</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Информация</h5>
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
            @else
                <div style="height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; width: 200px; border-radius: 50%; color: white;">{{ substr($user->name, 0, 1) }}</div>
            @endif
            <p><strong>Имя:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Роль:</strong> {{ $user->role }}</p>
            @if ($user->role === 'admin')
                <p class="text-success">Вы администратор</p>
            @endif
        </div>
    </div>

    <h2 class="mt-4">Редактировать профиль</h2>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label for="avatar" class="form-label">Аватар</label>
            <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection