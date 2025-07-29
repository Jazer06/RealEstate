<?php
namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->latest()->paginate(9);
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Property $property)
    {
        $user = Auth::user();
        if ($user->favorites()->where('property_id', $property->id)->exists()) {
            $user->favorites()->detach($property->id);
            $message = 'Удалено из избранного.';
        } else {
            $user->favorites()->attach($property->id);
            $message = 'Добавлено в избранное.';
        }

        return back()->with('success', $message);
    }
}