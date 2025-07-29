<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PublicPropertyController extends Controller
{
    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }
}