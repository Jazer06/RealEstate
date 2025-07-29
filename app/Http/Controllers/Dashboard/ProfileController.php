<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Необходимо войти в систему.');
        }

        $user = Auth::user();
        $favorites = $user->favorites()->latest()->paginate(9); // Загружаем избранные объекты с пагинацией

        return view('profile', compact('user', 'favorites'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Валидация и обновление
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'sometimes|nullable|string|max:18|regex:/^\+7 \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/',
            'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'new_password' => 'sometimes|nullable|string|min:6|confirmed',
            'new_password_confirmation' => 'sometimes|nullable|required_with:new_password',
        ], [
            'name.required' => 'Имя обязательно для заполнения.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'email.required' => 'Email обязателен для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
            'email.unique' => 'Этот email уже используется.',
            'phone.max' => 'Номер телефона должен быть в формате +7 (999) 123-45-67.',
            'phone.regex' => 'Введите корректный российский номер телефона в формате +7 (999) 123-45-67.',
            'avatar.image' => 'Файл должен быть изображением.',
            'avatar.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif.',
            'avatar.max' => 'Размер файла не должен превышать 2MB.',
            'new_password.required' => 'Новый пароль обязателен для заполнения.',
            'new_password.min' => 'Пароль должен содержать минимум 6 символов.',
            'new_password.confirmed' => 'Пароли не совпадают.',
            'new_password_confirmation.required' => 'Подтверждение пароля обязательно.',
        ]);

        // Проверка, что новый пароль отличается от текущего
        if ($request->filled('new_password') && Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Новый пароль должен отличаться от текущего.'])->withInput($request->except(['new_password', 'new_password_confirmation']));
        }

        // Обработка телефона
        if ($request->filled('phone')) {
            $cleanPhone = preg_replace('/[^\d]/', '', $request->phone);
            if (strlen($cleanPhone) == 11) {
                $validated['phone'] = '+7' . substr($cleanPhone, 1);
            } else {
                $validated['phone'] = null;
            }
        }

        // Обработка аватара
        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }
            $image = $request->file('avatar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $validated['avatar'] = $image->storeAs('avatars', $imageName, 'public');
        }

        // Обновление пароля, если передан
        if ($request->filled('new_password')) {
            $validated['password'] = Hash::make($request->new_password);
        }

        // Обновляем только заполненные поля
        $user->update(array_filter($validated));

        return back()->with('success', 'Профиль обновлён!');
    }
}