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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
        ]);

        Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'address' => $request->address,
            'user_id' => Auth::id(),
        ]);

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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
        ]);

        $property->update($request->only(['title', 'description', 'price', 'address']));
        return redirect()->route('dashboard.properties.index')->with('success', 'Объект обновлён!');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        $property->delete();
        return redirect()->route('dashboard.properties.index')->with('success', 'Объект удалён!');
    }
}