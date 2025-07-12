<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $properties = Property::where('user_id', Auth::id())->get();
        return view('dashboard.index', compact('properties'));
    }
}
