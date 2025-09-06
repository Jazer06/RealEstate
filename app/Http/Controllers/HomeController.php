<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sliders = Slider::all();

        // Диапазоны по умолчанию
        $minPrice = 0;
        $maxPrice = 30000000;
        $areaMinDefault = 20;
        $areaMaxDefault = 200;

        $query = Property::query();

        // Тип недвижимости
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // ЖК (slider_id)
        if ($request->filled('slider_id')) {
            $query->where('slider_id', $request->input('slider_id'));
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
        $areaMin = $request->input('area_range_min', $areaMinDefault);
        $areaMax = $request->input('area_range_max', $areaMaxDefault);
        $query->whereBetween('area', [$areaMin, $areaMax]);

        $properties = $query->latest()->paginate(6)->withQueryString();
        $totalProperties = $properties->total();

        $bannerTitle = Setting::where('key', 'banner_title')->value('value') ?? '';
        $bannerDescription = Setting::where('key', 'banner_description')->value('value') ?? '';

        return view('welcome', compact(
            'sliders',
            'properties',
            'totalProperties',
            'minPrice',
            'maxPrice',
            'priceMin',
            'priceMax',
            'areaMin',
            'areaMax',
            'bannerTitle',
            'bannerDescription'
        ));
    }
}
