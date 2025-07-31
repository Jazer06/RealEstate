<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Slider;
use App\Models\Contact; // Добавляем модель Contact
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $properties = Property::where('user_id', Auth::id())->get();
        $sliders = Slider::all();
        $contacts = Contact::all(); // Добавляем заявки
        return view('dashboard.index', compact('properties', 'sliders', 'contacts')); // Исправлено на 'dashboard.index'
    }
}