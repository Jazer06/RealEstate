<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Необходимо войти в систему.');
        }

        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $avatarPath = $user->avatar; // Сохраняем старый путь

        if ($request->hasFile('avatar')) {
            // Удаляем старую аватарку, если она есть
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }
            $image = $request->file('avatar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $avatarPath = $image->storeAs('avatars', $imageName, 'public'); 
        }

        $user->update(array_merge(
            $validated,
            ['avatar' => $avatarPath]
        ));

        return redirect()->route('profile')->with('success', 'Профиль обновлён!');
    }
}