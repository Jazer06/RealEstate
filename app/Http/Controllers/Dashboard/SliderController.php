<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Property;
use App\Rules\FlexibleUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'properties.*' => 'exists:properties,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images/sliders', $imageName, 'public');
        }

        // сначала создаём слайд без button_link
        $slider = Slider::create([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => null, // временно
            'image_path' => $imagePath,
        ]);

        // теперь обновляем ссылку
        $slider->update([
            'button_link' => url('/properties?type=&slider_id=' . $slider->id),
        ]);

        // Привязываем выбранные квартиры
        Property::whereIn('id', $request->properties ?? [])
            ->update(['slider_id' => $slider->id]);

        return redirect()->route('dashboard')->with('success', 'Слайд добавлен!');
    }


    public function edit(Slider $slider)
    {
        $this->authorize('update', $slider);

        $allProperties = Property::all();
        return view('dashboard.sliders.edit', compact('slider', 'allProperties'));
    }

    public function update(Request $request, Slider $slider)
    {
        $this->authorize('update', $slider);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'properties' => 'nullable|array',
            'properties.*' => 'exists:properties,id',
        ]);

        $imagePath = $slider->image_path;

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images/sliders', $imageName, 'public');
        }

        $slider->update([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => url('/properties?type=&slider_id=' . $slider->id),
            'image_path' => $imagePath,
        ]);

        // Отвязываем и привязываем квартиры
        Property::where('slider_id', $slider->id)->update(['slider_id' => null]);
        Property::whereIn('id', $request->properties ?? [])->update(['slider_id' => $slider->id]);

        return redirect()->route('dashboard')->with('success', 'Слайд обновлён!');
    }

    public function destroy(Slider $slider)
    {
        $this->authorize('delete', $slider);

        if ($slider->image_path && Storage::disk('public')->exists($slider->image_path)) {
            Storage::disk('public')->delete($slider->image_path);
        }

        // Отвязываем квартиры перед удалением слайдера
        Property::where('slider_id', $slider->id)->update(['slider_id' => null]);

        $slider->delete();

        return redirect()->route('dashboard')->with('success', 'Слайд удалён!');
    }
}
