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
        
        // Диапазоны по умолчанию
        $minPrice = 0;
        $maxPrice = 30000000;

        $query = Property::query();

        // Фильтр по типу: apartment, house, commercial
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Цена
        $priceMin = $request->input('price_range_min', $minPrice);
        $priceMax = $request->input('price_range_max', $maxPrice);
        $query->whereBetween('price', [$priceMin, $priceMax]);

        // Комнаты
        if ($request->filled('rooms')) {
            if ($request->input('rooms') == '4') {
                $query->where('rooms', '>=', 4);
            } else {
                $query->where('rooms', $request->input('rooms'));
            }
        }

        // Площадь
        $areaMin = $request->input('area_range_min', 20);
        $areaMax = $request->input('area_range_max', 200);
        $query->whereBetween('area', [$areaMin, $areaMax]);

        $properties = $query->latest()->paginate(5);
        $totalProperties = $properties->total();

        return view('welcome', compact(
            'sliders',
            'properties',
            'totalProperties',
            'minPrice',
            'maxPrice',
            'priceMin',
            'priceMax',
            'areaMin',
            'areaMax'
        ));
    }
}
