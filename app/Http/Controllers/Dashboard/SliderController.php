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
            'adress' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime|max:20000',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'is_construction.*' => 'nullable|boolean', // Валидация для флажков "ход строительства"
            'properties' => 'nullable|array',
            'properties.*' => 'nullable|exists:properties,id',
        ]);

        $imagePath = null;
        $videoPath = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images/sliders', $imageName, 'public');
        }

        if ($request->hasFile('video')) {
            $videoName = time() . '_' . $request->file('video')->getClientOriginalName();
            $videoPath = $request->file('video')->storeAs('videos/sliders', $videoName, 'public');
        }

        $slider = Slider::create([
            'title' => $validated['title'] ?? null,
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'adress' => $validated['adress'] ?? null,
            'button_text' => $validated['button_text'] ?? 'Смотреть все ЖК',
            'button_link' => null,
            'image_path' => $imagePath,
            'video_path' => $videoPath,
        ]);

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $additionalImage) {
                $additionalImageName = time() . '_' . $additionalImage->getClientOriginalName();
                $additionalImagePath = $additionalImage->storeAs('images/sliders', $additionalImageName, 'public');
                SliderImage::create([
                    'slider_id' => $slider->id,
                    'image_path' => $additionalImagePath,
                    'is_construction' => $request->input('is_construction.' . $index, false), // Флажок "ход строительства"
                ]);
            }
        }

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
        $this->authorize('update', $slider);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'adress' => 'nullable|string',
            'button_text' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime|max:20000',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:15360',
            'is_construction.*' => 'nullable|boolean',
            'is_construction_existing.*' => 'nullable|boolean', // Валидация для существующих изображений
        ]);

        $imagePath = $slider->image_path;
        $videoPath = $slider->video_path;

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images/sliders', $imageName, 'public');
        }

        if ($request->hasFile('video')) {
            if ($videoPath && Storage::disk('public')->exists($videoPath)) {
                Storage::disk('public')->delete($videoPath);
            }
            $videoName = time() . '_' . $request->file('video')->getClientOriginalName();
            $videoPath = $request->file('video')->storeAs('videos/sliders', $videoName, 'public');
        }

        $slider->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'description' => $validated['description'] ?? null,
            'adress' => $validated['adress'] ?? null,
            'button_text' => $validated['button_text'],
            'image_path' => $imagePath,
            'video_path' => $videoPath,
        ]);

        // Обновление is_construction для существующих изображений
        if ($request->has('is_construction_existing')) {
            foreach ($request->input('is_construction_existing', []) as $imageId => $isConstruction) {
                SliderImage::where('id', $imageId)->update(['is_construction' => (bool)$isConstruction]);
            }
        }

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $additionalImage) {
                $additionalImageName = time() . '_' . $additionalImage->getClientOriginalName();
                $additionalImagePath = $additionalImage->storeAs('images/sliders', $additionalImageName, 'public');
                SliderImage::create([
                    'slider_id' => $slider->id,
                    'image_path' => $additionalImagePath,
                    'is_construction' => $request->input('is_construction.' . $index, false),
                ]);
            }
        }

        $buttonLink = url('/properties') . '?slider_id=' . $slider->id;
        $slider->update(['button_link' => $buttonLink]);

        return redirect()->route('dashboard')->with('success', 'Слайд обновлён!');
    }
    public function destroy(Slider $slider)
    {
        $this->authorize('delete', $slider);

        if ($slider->image_path && Storage::disk('public')->exists($slider->image_path)) {
            Storage::disk('public')->delete($slider->image_path);
        }

        if ($slider->video_path && Storage::disk('public')->exists($slider->video_path)) {
            Storage::disk('public')->delete($slider->video_path);
        }

        foreach ($slider->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        Property::where('slider_id', $slider->id)->update(['slider_id' => null]);

        $slider->delete();

        return redirect()->route('dashboard')->with('success', 'Слайд удалён!');
    }

    public function destroyImage(Request $request, SliderImage $sliderImage)
    {
        try {
            if ($sliderImage->image_path && Storage::disk('public')->exists($sliderImage->image_path)) {
                Storage::disk('public')->delete($sliderImage->image_path);
            }
            $sliderImage->delete();
            return response()->json(['success' => true, 'message' => 'Дополнительное изображение удалено.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroyVideo(Request $request, Slider $slider)
    {
        try {
            if ($slider->video_path && Storage::disk('public')->exists($slider->video_path)) {
                Storage::disk('public')->delete($slider->video_path);
            }
            $slider->update(['video_path' => null]);
            return response()->json(['success' => true, 'message' => 'Видео удалено.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}