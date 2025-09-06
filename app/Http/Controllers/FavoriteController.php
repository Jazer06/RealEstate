<?php
namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use App\Models\PurchaseRequest;
use App\Models\WhatsAppSender;
use Illuminate\Http\Request;

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
        $userId = auth()->id();
        $favorite = Favorite::where('user_id', $userId)->where('property_id', $property->id)->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Удалено из избранного!';
        } else {
            Favorite::create([
                'user_id' => $userId,
                'property_id' => $property->id,
            ]);
            $message = 'Добавлено в избранное!';
        }

        // Проверяем, является ли запрос AJAX (для кнопки "Узнать цену")
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        // Для обычных запросов (кнопка с сердцем) возвращаем редирект
        return redirect()->back()->with('success', $message);
    }

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

    public function destroy(Favorite $favorite)
    {
        if ($favorite->user_id !== auth()->id()) {
            abort(403, 'Недостаточно прав для удаления');
        }

        $favorite->delete();

        return redirect()->route('favorites.index')->with('success', 'Объект удалён из избранного.');
    }
}