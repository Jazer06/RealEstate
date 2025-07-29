<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Property;
use Illuminate\Http\Request;


class HomeController extends Controller
{
public function index(Request $request)
    {
        $sliders = Slider::all();

        // Получаем параметры фильтров
        $query = Property::query();

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }
        if ($request->filled('area_min')) {
            $query->where('area', '>=', $request->input('area_min'));
        }
        if ($request->filled('area_max')) {
            $query->where('area', '<=', $request->input('area_max'));
        }
        if ($request->filled('rooms')) {
            if ($request->input('rooms') == '4') {
                $query->where('rooms', '>=', 4);
            } else {
                $query->where('rooms', $request->input('rooms'));
            }
        }
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        $properties = $query->latest()->paginate(9);

        return view('welcome', compact('sliders', 'properties'));
    }
}
