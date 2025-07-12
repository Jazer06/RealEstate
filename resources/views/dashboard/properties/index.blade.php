@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Мои объекты</h1>
    <a href="{{ route('dashboard.properties.create') }}" class="btn btn-success mb-3">Добавить объект</a>
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Адрес</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($properties as $property)
                <tr>
                    <td>{{ $property->title }}</td>
                    <td>{{ $property->address }}</td>
                    <td>{{ number_format($property->price, 2) }} ₽</td>
                    <td>
                        <a href="{{ route('dashboard.properties.edit', $property) }}" class="btn btn-sm btn-primary">Редактировать</a>
                        <form action="{{ route('dashboard.properties.destroy', $property) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить объект?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection