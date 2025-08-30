<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\SliderImage;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with('images')->get();
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
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
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
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? 'Смотреть все ЖК',
            'button_link' => null,
            'image_path' => $imagePath,
        ]);

        // Загрузка дополнительных изображений
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $additionalImage) {
                $additionalImageName = time() . '_' . $additionalImage->getClientOriginalName();
                $additionalImagePath = $additionalImage->storeAs('images/sliders', $additionalImageName, 'public');
                SliderImage::create([
                    'slider_id' => $slider->id,
                    'image_path' => $additionalImagePath,
                ]);
            }
        }

        // Привязка квартир
        $selectedProperties = $request->properties ?? [];
        $selectedProperties = array_filter($selectedProperties, fn($value) => $value !== '' && $value !== null);

        if (empty($selectedProperties)) {
            $buttonLink = url('/properties') . '?slider_id=' . $slider->id;
        } else {
            $buttonLink = url('/properties') . '?slider_id=' . $slider->id;
            Property::whereIn('id', $selectedProperties)->update(['slider_id' => $slider->id]);
        }

        $slider->update(['button_link' => $buttonLink]);

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
        // $this->authorize('update', $slider); // Временно отключено для отладки

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'properties' => 'nullable|array',
            'properties.*' => 'nullable|exists:properties,id',
        ]);

        \Log::info('Validated data:', $validated); // Логирование для отладки

        $imagePath = $slider->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images/sliders', $imageName, 'public');
        }

        // Обновляем слайдер
        $slider->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'],
            'image_path' => $imagePath,
        ]);

        // Обработка дополнительных изображений
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $additionalImage) {
                $additionalImageName = time() . '_' . $additionalImage->getClientOriginalName();
                $additionalImagePath = $additionalImage->storeAs('images/sliders', $additionalImageName, 'public');
                SliderImage::create([
                    'slider_id' => $slider->id,
                    'image_path' => $additionalImagePath,
                ]);
            }
        }

        // Привязка квартир
        $selectedProperties = $request->properties ?? [];
        $selectedProperties = array_filter($selectedProperties, fn($value) => $value !== '' && $value !== null);

        // Отвязываем старые свойства
        Property::where('slider_id', $slider->id)->update(['slider_id' => null]);

        if (empty($selectedProperties)) {
            $buttonLink = url('/properties') . '?slider_id=' . $slider->id;
        } else {
            $buttonLink = url('/properties') . '?slider_id=' . $slider->id;
            Property::whereIn('id', $selectedProperties)->update(['slider_id' => $slider->id]);
        }

        $slider->update(['button_link' => $buttonLink]);

        return redirect()->route('dashboard')->with('success', 'Слайд обновлён!');
    }

    public function destroy(Slider $slider)
    {
        $this->authorize('delete', $slider);

        // Удаляем основное изображение
        if ($slider->image_path && Storage::disk('public')->exists($slider->image_path)) {
            Storage::disk('public')->delete($slider->image_path);
        }

        // Удаляем дополнительные изображения
        foreach ($slider->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // Отвязываем квартиры
        Property::where('slider_id', $slider->id)->update(['slider_id' => null]);

        $slider->delete();

        return redirect()->route('dashboard')->with('success', 'Слайд удалён!');
    }

    public function destroyImage(Request $request, SliderImage $sliderImage)
    {
        try {
            // Удаляем файл из хранилища
            if ($sliderImage->image_path && Storage::disk('public')->exists($sliderImage->image_path)) {
                Storage::disk('public')->delete($sliderImage->image_path);
            }
            // Удаляем запись из базы
            $sliderImage->delete();
            return response()->json(['success' => true, 'message' => 'Дополнительное изображение удалено.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}