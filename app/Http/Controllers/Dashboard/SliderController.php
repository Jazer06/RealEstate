<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('dashboard.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('dashboard.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('images/sliders', $imageName, 'public');
        }

        Slider::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'button_text' => $validated['button_text'],
            'button_link' => $validated['button_link'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Слайд добавлен!');
    }

    public function edit(Slider $slider)
    {
        $this->authorize('update', $slider);
        return view('dashboard', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $this->authorize('update', $slider);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $slider->image_path;
        if ($request->hasFile('image')) {
            // Удаляем старую картинку, если она есть
            if ($slider->image_path && file_exists(storage_path('app/public/' . $slider->image_path))) {
                unlink(storage_path('app/public/' . $slider->image_path));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('images/sliders', $imageName, 'public');
        }

        $slider->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'button_text' => $validated['button_text'],
            'button_link' => $validated['button_link'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Слайд обновлен!');
    }

    public function destroy(Slider $slider)
    {
        $this->authorize('delete', $slider);
        if ($slider->image_path && file_exists(storage_path('app/public/' . $slider->image_path))) {
            unlink(storage_path('app/public/' . $slider->image_path));
        }
        $slider->delete();
        return redirect()->route('dashboard')->with('success', 'Слайд удален!');
    }
}