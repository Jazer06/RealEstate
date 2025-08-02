<?php   
// app/Http/Controllers/PublicPropertyController.php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PublicPropertyController extends Controller
{
    // ✅ Список всех объектов
    public function index()
    {
        $properties = Property::latest()->paginate(9); // 9 объектов на странице
        return view('properties.index', compact('properties'));
    }

    // Просмотр одного объекта
    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }
} 