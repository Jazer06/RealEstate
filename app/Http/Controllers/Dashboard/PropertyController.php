<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Slider;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PurchaseRequest;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('user_id', Auth::id())->paginate(5);
        $sliders = Slider::all();
        $contacts = Contact::paginate(5);
        $purchaseRequests = PurchaseRequest::with(['user', 'property'])->paginate(5);

        return view('dashboard.index', compact('properties', 'sliders', 'contacts', 'purchaseRequests'));
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
            'price' => 'required|numeric|max:30000000', 
            'address' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'rooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string|in:квартира,дом,коммерческая',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', 
            'plan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'additional_images' => 'nullable|array|max:5',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $property = new Property($validated);
        $property->user_id = Auth::id();

        // Главное фото
        if ($request->hasFile('image_path')) {
            $property->image_path = $request->file('image_path')->store('properties', 'public');
        }

        $property->save();

        // План дома
        if ($request->hasFile('plan_image')) {
            $path = $request->file('plan_image')->store('property_images', 'public');
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'is_plan' => true,
            ]);
        }

        // Доп. изображения
        if ($request->hasFile('additional_images')) {
            foreach (array_slice($request->file('additional_images'), 0, 5) as $image) {
                $path = $image->store('property_images', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                    'is_plan' => false,
                ]);
            }
        }

        return redirect()->route('dashboard.properties.index')->with('success', 'Объект успешно добавлен!');
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
            'price' => 'required|numeric|max:30000000', 
            'address' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'rooms' => 'nullable|integer|min:0',
            'type' => 'nullable|string|in:квартира,дом,коммерческая',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'plan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'additional_images' => 'nullable|array|max:5',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:property_images,id',
        ]);

        // Обновление главного фото
        if ($request->hasFile('image_path')) {
            if ($property->image_path) {
                Storage::disk('public')->delete($property->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('properties', 'public');
        }

        $property->update($validated);

        // Обновление плана дома
        if ($request->hasFile('plan_image')) {
            $oldPlan = $property->images()->where('is_plan', true)->first();
            if ($oldPlan) {
                Storage::disk('public')->delete($oldPlan->image_path);
                $oldPlan->delete();
            }

            $path = $request->file('plan_image')->store('property_images', 'public');
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'is_plan' => true,
            ]);
        }

        // Удаление выбранных изображений
        if ($request->has('delete_images')) {
            $imagesToDelete = $property->images()
                ->where('is_plan', false)
                ->whereIn('id', $request->input('delete_images'))
                ->get();

            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        // Добавление новых изображений (лимит 5)
        if ($request->hasFile('additional_images')) {
            $currentCount = $property->images()->where('is_plan', false)->count();
            $availableSlots = 5 - $currentCount;

            $newImages = array_slice($request->file('additional_images'), 0, $availableSlots);

            foreach ($newImages as $image) {
                $path = $image->store('property_images', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                    'is_plan' => false,
                ]);
            }
        }

        return redirect()->route('dashboard.properties.index')->with('success', 'Объект успешно обновлён!');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        if ($property->image_path) {
            Storage::disk('public')->delete($property->image_path);
        }

        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $property->images()->delete();
        $property->delete();

        return redirect()->route('dashboard.properties.index')->with('success', 'Объект успешно удалён!');
    }

    public function contacts()
    {
        $contacts = Contact::latest()->paginate(10);
        $properties = Property::where('user_id', Auth::id())->paginate(5);
        $sliders = Slider::all();

        return view('dashboard.index', compact('contacts', 'properties', 'sliders'));
    }
}
