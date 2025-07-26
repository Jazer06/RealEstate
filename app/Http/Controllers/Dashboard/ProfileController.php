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
        $user = Auth::user();

        // Если загружается только аватар (через onchange)
        if ($request->hasFile('avatar') && !$request->filled('name')) {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Удаляем старую аватарку
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }

            // Сохраняем новую
            $image = $request->file('avatar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $avatarPath = $image->storeAs('avatars', $imageName, 'public');

            $user->update(['avatar' => $avatarPath]);

            return back()->with('success', 'Аватар обновлён!');
        }

        // Если обновляются данные из модалки
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'surname' => 'nullable|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Обновляем данные
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'surname' => $validated['surname'] ?? $user->surname,
            'patronymic' => $validated['patronymic'] ?? $user->patronymic,
            'phone' => $validated['phone'] ?? $user->phone,
        ];

        // Если указан новый пароль
        if (!empty($validated['new_password'])) {
            $userData['password'] = bcrypt($validated['new_password']);
        }

        // Обновляем аватар, если он был загружен
        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }
            $image = $request->file('avatar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $avatarPath = $image->storeAs('avatars', $imageName, 'public');
            $userData['avatar'] = $avatarPath;
        }

        $user->update($userData);

        return back()->with('success', 'Профиль обновлён!');
    }
}