<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Slider;
use Illuminate\Http\Request;

class PublicPropertyController extends Controller
{
    public function index(Request $request)
    {
        // Диапазоны по умолчанию
        $minPrice = 0;
        $maxPrice = 30000000;
        $areaMin = 20;
        $areaMax = 200;

        $query = Property::query();

        // Фильтр по типу
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Фильтр по ЖК
        if ($request->filled('slider_id')) {
            $query->where('slider_id', $request->input('slider_id'));
        }

        // Фильтр по цене
        $priceMin = $request->input('price_range_min', $minPrice);
        $priceMax = $request->input('price_range_max', $maxPrice);
        $query->whereBetween('price', [$priceMin, $priceMax]);

        // Фильтр по комнатам
        if ($request->filled('rooms')) {
            if ($request->input('rooms') == '4') {
                $query->where('rooms', '>=', 4);
            } else {
                $query->where('rooms', $request->input('rooms'));
            }
        }

        // Фильтр по площади
        $areaMin = $request->input('area_range_min', $areaMin);
        $areaMax = $request->input('area_range_max', $areaMax);
        $query->whereBetween('area', [$areaMin, $areaMax]);

        $properties = $query->latest()->paginate(9)->withQueryString();
        $totalProperties = $properties->total();

        // Все доступные ЖК — для фильтра
        $sliders = Slider::all();

        return view('properties.index', compact(
            'properties',
            'minPrice',
            'maxPrice',
            'priceMin',
            'priceMax',
            'areaMin',
            'areaMax',
            'totalProperties',
            'sliders'
        ));
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }
}
