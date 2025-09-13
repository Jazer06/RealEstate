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
    $minPrice = 0;
    $maxPrice = 30000000;
    $areaMinDefault = 16;
    $areaMaxDefault = 200;

    $query = Property::query();

    // Тип недвижимости
    if ($request->filled('type')) {
        $query->where('type', $request->input('type'));
    }

    // ЖК (slider_id)
    $sliderId = $request->input('slider_id');

    if (!empty($sliderId)) {
        $query->where('slider_id', $sliderId);
        // 👉 табы (для десктопа) — только выбранный ЖК
        $sliders = Slider::where('id', $sliderId)->get();
    } else {
        // 👉 табы (для десктопа) — все ЖК
        $sliders = Slider::all();
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

    // Получаем все подходящие записи
    $properties = $query->latest()->get();

    $totalProperties = $properties->count();

    $bannerTitle = Setting::where('key', 'banner_title')->value('value') ?? '';
    $bannerDescription = Setting::where('key', 'banner_description')->value('value') ?? '';

    // 👉 Для фильтров (селект) всегда нужны ВСЕ ЖК
    $allSliders = Slider::all();

    return view('welcome', compact(
        'sliders',        // для табов
        'allSliders',     // для фильтров
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
