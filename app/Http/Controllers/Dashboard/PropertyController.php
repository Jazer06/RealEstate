<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('user_id', Auth::id())->get();
        $sliders = Slider::all();
        return view('dashboard.index', compact('properties', 'sliders'));
    }

    public function create()
    {
        return view('dashboard.properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'address' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'rooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string|in:квартира,дом,коммерческая',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $property = new Property($validated);
        $property->user_id = Auth::id();

        if ($request->hasFile('image_path')) {
            $property->image_path = $request->file('image_path')->store('properties', 'public');
        }

        $property->save();

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('property_images', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard.properties.index')->with('success', 'Объект добавлен!');
    }

    public function show(Property $property)
    {
        return view('dashboard.properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        return view('dashboard.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'address' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'rooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string|in:квартира,дом,коммерческая',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            // Удаляем старое основное изображение, если оно есть
            if ($property->image_path) {
                Storage::disk('public')->delete($property->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('properties', 'public');
        }

        $property->update($validated);

        if ($request->hasFile('additional_images')) {
            // Удаляем старые дополнительные изображения, если нужно
            $property->images()->delete();
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('property_images', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('dashboard.properties.index')->with('success', 'Объект обновлён!');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        // Удаляем основное изображение
        if ($property->image_path) {
            Storage::disk('public')->delete($property->image_path);
        }

        // Удаляем дополнительные изображения
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $property->images()->delete();

        $property->delete();
        return redirect()->route('dashboard.properties.index')->with('success', 'Объект удалён!');
    }
}