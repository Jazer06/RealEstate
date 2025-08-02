<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    public function index()
    {
        $propertyIds = Favorite::where('user_id', auth()->id())->pluck('property_id');
        $favorites = Property::whereIn('id', $propertyIds)->paginate(10);

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request, Property $property)
    {
        $favorite = Favorite::where('user_id', auth()->id())->where('property_id', $property->id)->first();
        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'Удалено из избранного!');
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'property_id' => $property->id,
            ]);
            return redirect()->back()->with('success', 'Добавлено в избранное!');
        }
    }

    public function createPurchaseRequest(Request $request, Property $property)
    {
        try {
            $request->validate([
                'comment' => 'nullable|string|max:1000',
            ]);

            $userId = auth()->id();

            // Проверка: в избранном?
            $existsInFavorites = Favorite::where('user_id', $userId)
                ->where('property_id', $property->id)
                ->exists();

            if (!$existsInFavorites) {
                return redirect()->back()->with('error', '❌ Объект не в избранном.');
            }

            // Уже есть заявка?
            if (PurchaseRequest::where('user_id', $userId)->where('property_id', $property->id)->exists()) {
                return redirect()->back()->with('error', '⚠️ Заявка уже отправлена.');
            }

            // Создаём заявку
            PurchaseRequest::create([
                'user_id' => $userId,
                'property_id' => $property->id,
                'comment' => $request->input('comment'),
                'status' => 'pending',
            ]);

            // 🔥 Удаляем из избранного напрямую
            Favorite::where('user_id', $userId)
                ->where('property_id', $property->id)
                ->delete();

            return redirect()->back()->with('success', '✅ Заявка отправлена! Наш менеджер с вами свяжется.');

        } catch (\Exception $e) {
            \Log::error('Ошибка заявки: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ Ошибка. Попробуйте позже.');
        }
    }

    public function destroy(Favorite $favorite)
    {
        if ($favorite->user_id !== auth()->id()) {
            abort(403, 'Недостаточно прав для удаления');
        }

        $favorite->delete();

        return redirect()->route('favorites.index')->with('success', 'Объект удалён из избранного.');
    }
}