<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use App\Models\PurchaseRequest;
use App\Models\WhatsAppSender;
use Illuminate\Http\Request;

/**
 * Контроллер для управления избранными объектами недвижимости и заявками на покупку.
 */
class FavoriteController extends Controller
{
    /**
     * Отображает список избранных объектов недвижимости текущего пользователя.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $propertyIds = Favorite::where('user_id', auth()->id())->pluck('property_id');
        $favorites = Property::whereIn('id', $propertyIds)->paginate(10);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Добавляет или удаляет объект недвижимости из избранного текущего пользователя.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Request $request, Property $property)
    {
        $favorite = Favorite::where('user_id', auth()->id())->where('property_id', $property->id)->first();
        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'Удалено из избранного!');
        }

        Favorite::create([
            'user_id' => auth()->id(),
            'property_id' => $property->id,
        ]);
        return redirect()->back()->with('success', 'Добавлено в избранное!');
    }

    /**
     * Создаёт заявку на покупку объекта недвижимости и отправляет уведомление в WhatsApp.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property $property
     * @return \Illuminate\Http\RedirectResponse
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
            'user_id' => $userId,
            'property_id' => $property->id,
            'comment' => $request->input('comment'),
            'status' => 'pending',
        ]);

        Favorite::where('user_id', $userId)
            ->where('property_id', $property->id)
            ->delete();

        $this->sendPurchaseRequestToWhatsApp($purchaseRequest, $property);

        return redirect()->back()->with('success', '✅ Заявка отправлена! Наш менеджер с вами свяжется.');
    }

    /**
     * Отправляет уведомление о новой заявке на покупку в WhatsApp-группу.
     *
     * @param \App\Models\PurchaseRequest $purchaseRequest
     * @param \App\Models\Property $property
     * @return void
     */
    private function sendPurchaseRequestToWhatsApp(PurchaseRequest $purchaseRequest, Property $property)
    {
        $message = "📢 *Новая заявка на покупку!*\n"
                 . "👤 *Пользователь:* " . auth()->user()->name . "\n"
                 . "🏠 *Объект:* {$property->title}\n"
                 . "💬 *Комментарий:* " . ($purchaseRequest->comment ?: 'Без комментария') . "\n\n"
                 . "🕒 " . now()->format('d.m.Y H:i');

        $whatsAppSender = new WhatsAppSender();
        $success = $whatsAppSender->send($message);

        if (!$success) {
            return back()->withErrors(['whatsapp' => 'Не удалось отправить сообщение в WhatsApp.'])->withInput();
        }
    }

    /**
     * Удаляет объект из избранного текущего пользователя.
     *
     * @param \App\Models\Favorite $favorite
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Favorite $favorite)
    {
        if ($favorite->user_id !== auth()->id()) {
            abort(403, 'Недостаточно прав для удаления');
        }

        $favorite->delete();

        return redirect()->route('favorites.index')->with('success', 'Объект удалён из избранного.');
    }
}