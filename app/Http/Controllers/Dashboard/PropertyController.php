<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('user_id', Auth::id())->get();
        return view('dashboard.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('dashboard.properties.create');
    }

    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // Обработка изображения
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); 
            $imagePath = $image->storeAs('images', $imageName, 'public'); 
        }

        // Создание объекта Property
        Property::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'address' => $validated['address'],
            'user_id' => Auth::id(),
            'image' => $imagePath, // Сохраняем путь к файлу
        ]);

        // Редирект с сообщением об успехе
        return redirect()->route('dashboard.properties.index')->with('success', 'Объект добавлен!');
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
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048', 
        ]);

        $imageData = $property->image; // Сохраняем старую картинку, если новая не загружена
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = base64_encode(file_get_contents($image->getRealPath()));
        }

        $property->update(array_merge(
            $validated,
            ['image' => $imageData]
        ));

        return redirect()->route('dashboard.properties.index')->with('success', 'Объект обновлён!');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        $property->delete();
        return redirect()->route('dashboard.properties.index')->with('success', 'Объект удалён!');
    }
}