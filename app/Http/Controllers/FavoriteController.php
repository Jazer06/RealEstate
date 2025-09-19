<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use App\Models\PurchaseRequest;
use App\Models\WhatsAppSender;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Список избранного пользователя
     */
    public function index()
    {
        $propertyIds = Favorite::where('user_id', auth()->id())->pluck('property_id');
        $favorites   = Property::whereIn('id', $propertyIds)->paginate(10);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Переключение избранного (сердце)
     */
    public function toggle(Request $request, Property $property)
    {
        $userId = auth()->id();

        $favorite = Favorite::where('user_id', $userId)
            ->where('property_id', $property->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = '❌ Удалено из избранного!';
        } else {
            Favorite::create([
                'user_id'     => $userId,
                'property_id' => $property->id,
            ]);
            $message = '✅ Добавлено в избранное!';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Кнопка "Узнать цену" → добавить в избранное и перебросить в список
     */
    public function addAndRedirect(Property $property)
    {
        $userId = auth()->id();

        $exists = Favorite::where('user_id', $userId)
            ->where('property_id', $property->id)
            ->exists();

        if (!$exists) {
            Favorite::create([
                'user_id'     => $userId,
                'property_id' => $property->id,
            ]);
        }

        return redirect()->route('favorites.index')
            ->with('success', '✅ Объект добавлен в избранное. Смотрите в разделе «Избранное».');
    }


    public function addAndRedirectToProfile(Property $property)
    {
        $userId = auth()->id();

        // Добавляем в избранное, если его ещё нет
        $exists = Favorite::where('user_id', $userId)
            ->where('property_id', $property->id)
            ->exists();

        if (!$exists) {
            Favorite::create([
                'user_id'     => $userId,
                'property_id' => $property->id,
            ]);
        }

        return redirect()->route('profile')->with('success', '✅ Объект добавлен в избранное. Отправьте заявку!.');
    }


    /**
     * Заявка на покупку (остаётся как у тебя)
     */
    public function createPurchaseRequest(Request $request, Property $property)
    {
        $request->validate([
            'comment' => 'nullable|string|max:1000',
        ]);

        $userId = auth()->id();

        $existsInFavorites = Favorite::where('user_id', $userId)
            ->where('property_id', $property->id)
            ->exists();

        if (!$existsInFavorites) {
            return redirect()->back()->with('error', '❌ Объект не в избранном.');
        }

        if (PurchaseRequest::where('user_id', $userId)->where('property_id', $property->id)->exists()) {
            return redirect()->back()->with('error', '⚠️ Заявка уже отправлена.');
        }

        $purchaseRequest = PurchaseRequest::create([
            'user_id'     => $userId,
            'property_id' => $property->id,
            'comment'     => $request->input('comment'),
            'status'      => 'pending',
        ]);

        Favorite::where('user_id', $userId)
            ->where('property_id', $property->id)
            ->delete();

        $this->sendPurchaseRequestToWhatsApp($purchaseRequest, $property);

        return redirect()->back()->with('success', '✅ Заявка отправлена! Наш менеджер с вами свяжется.');
    }

    private function sendPurchaseRequestToWhatsApp(PurchaseRequest $purchaseRequest, Property $property)
    {
        $message = "📢 *Новая заявка на покупку!*\n"
            . "👤 *Пользователь:* " . auth()->user()->name . "\n"
            . "🏠 *Объект:* {$property->title}\n"
            . "💬 *Комментарий:* " . ($purchaseRequest->comment ?: 'Без комментария') . "\n\n"
            . "🕒 " . now()->format('d.m.Y H:i');

        $whatsAppSender = new WhatsAppSender();
        $whatsAppSender->send($message);
    }
}
