@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Админ-панель</h1>
    <p>Добро пожаловать, {{ Auth::user()->name }}!</p>
    <a href="{{ route('dashboard.properties.index') }}" class="btn btn-primary">Управление объектами</a>
</div>


@endsection