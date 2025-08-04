<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {  
        $properties = Property::where('user_id', Auth::id())->paginate(5);
        $sliders = Slider::paginate(5);
        $contacts = Contact::paginate(5);
        $purchaseRequests = PurchaseRequest::with(['user', 'property'])->paginate(5);

        return view('dashboard.index', compact('properties', 'sliders', 'contacts', 'purchaseRequests'));
    }

    public function purchaseRequests()
    {
        $purchaseRequests = PurchaseRequest::with(['user', 'property'])->paginate(10);
        return view('dashboard.purchase-requests.index', compact('purchaseRequests'));
    }

    public function destroyPurchaseRequest(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->delete();
        return redirect()->route('dashboard.purchase-requests.index')->with('success', 'Заявка удалена!');
    }

    // Обновление телефона
    public function updatePhone(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string|max:20',
        ]);

        Setting::updateOrCreate(['key' => 'header_phone_number'], ['value' => $validated['phone_number'], 'type' => 'text']);

        return redirect()->back()->with('success', 'Телефон обновлён!');
    }

    // Обновление email
    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email:rfc,dns|max:255',
        ]);

        Setting::updateOrCreate(['key' => 'header_email'], ['value' => $validated['email'], 'type' => 'email']);

        return redirect()->back()->with('success', 'Email обновлён!');
    }

    public function updateBannerText(Request $request)
    {
        $request->validate([
            'banner_title' => 'required|string|max:255',
            'banner_description' => 'required|string',
        ]);

        Setting::updateOrCreate(['key' => 'banner_title'], [
            'value' => $request->input('banner_title'),
            'type' => 'text'
        ]);

        Setting::updateOrCreate(['key' => 'banner_description'], [
            'value' => $request->input('banner_description'),
            'type' => 'text'
        ]);

        return redirect()->back()->with('success', 'Баннер обновлён.');
    }


}