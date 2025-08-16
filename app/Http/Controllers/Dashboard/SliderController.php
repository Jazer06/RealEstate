<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('dashboard.sliders.index', compact('sliders'));
    }

    public function create()
    {
        $allProperties = Property::all();
        return view('dashboard.sliders.create', compact('allProperties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'properties' => 'nullable|array',
            'properties.*' => 'nullable|exists:properties,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images/sliders', $imageName, 'public');
        }

        // Создаем слайдер
        $slider = Slider::create([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?? 'Смотреть все ЖК',
            'button_link' => null, // временно
            'image_path' => $imagePath,
        ]);

        // Привязка квартир
        $selectedProperties = $request->properties ?? [];
        
        // Фильтруем пустые значения
        $selectedProperties = array_filter($selectedProperties, function($value) {
            return $value !== '' && $value !== null;
        });

        // Устанавливаем кнопку в зависимости от выбора
        if (empty($selectedProperties)) {
            // Все ЖК - ведет на список всех с этим slider_id
            $buttonLink = url('/properties') . '?slider_id=' . $slider->id;
        } else {
            // Конкретные ЖК - ведет на список с фильтром
            $buttonLink = url('/properties') . '?slider_id=' . $slider->id;
            // Привязываем выбранные ЖК к этому слайдеру
            Property::whereIn('id', $selectedProperties)->update(['slider_id' => $slider->id]);
        }

        // Обновляем ссылку кнопки
        $slider->update([
            'button_link' => $buttonLink,
        ]);

        return redirect()->route('dashboard')->with('success', 'Слайд добавлен!');
    }

    public function edit(Slider $slider)
    {
        $this->authorize('update', $slider);

        $allProperties = Property::all();
        return view('dashboard.sliders.edit', compact('slider', 'allProperties'));
    }

    public function destroy(Slider $slider)
    {
        $this->authorize('delete', $slider);

        if ($slider->image_path && Storage::disk('public')->exists($slider->image_path)) {
            Storage::disk('public')->delete($slider->image_path);
        }

        // Отвязываем квартиры перед удалением
        Property::where('slider_id', $slider->id)->update(['slider_id' => null]);

        $slider->delete();

        return redirect()->route('dashboard')->with('success', 'Слайд удалён!');
    }
}