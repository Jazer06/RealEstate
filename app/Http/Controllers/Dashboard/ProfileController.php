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
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Если загружается только аватар
        if ($request->hasFile('avatar') && !$request->filled('name') && !$request->filled('email') && !$request->filled('phone') && !$request->filled('new_password')) {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'avatar.required' => 'Файл аватара обязателен для загрузки.',
                'avatar.image' => 'Файл должен быть изображением.',
                'avatar.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif.',
                'avatar.max' => 'Размер файла не должен превышать 2MB.',
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

        // Раздельное обновление - проверяем, какие поля пришли
        $userData = [];

        // Обновление имени (только если оно передано)
        if ($request->filled('name')) {
            $request->validate([
                'name' => 'required|string|max:255',
            ], [
                'name.required' => 'Имя обязательно для заполнения.',
                'name.max' => 'Имя не должно превышать 255 символов.',
            ]);
            $userData['name'] = $request->name;
        }

        // Обновление email (только если он передан)
        if ($request->filled('email')) {
            $request->validate([
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
            ], [
                'email.required' => 'Email обязателен для заполнения.',
                'email.email' => 'Введите корректный email адрес.',
                'email.unique' => 'Этот email уже используется.',
            ]);
            $userData['email'] = $request->email;
        }

        // Обновление телефона (только если он передан)
        if ($request->filled('phone')) {
            if ($request->phone) {
                $request->validate([
                    'phone' => ['nullable', 'string', 'max:18', 'regex:/^\+7 \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/'],
                ], [
                    'phone.max' => 'Номер телефона должен быть в формате +7 (999) 123-45-67.',
                    'phone.regex' => 'Введите корректный российский номер телефона в формате +7 (999) 123-45-67.',
                ]);
                // Очищаем телефон от лишних символов для хранения
                $cleanPhone = preg_replace('/[^\d]/', '', $request->phone);
                if (strlen($cleanPhone) == 11) {
                    $userData['phone'] = '+7' . substr($cleanPhone, 1);
                } else {
                    $userData['phone'] = null;
                }
            } else {
                $userData['phone'] = null;
            }
        }

        // Обновление пароля (только если он передан)
        if ($request->filled('new_password')) {
            // Проверка, что новый пароль отличается от текущего
            if (Hash::check($request->new_password, $user->password)) {
                return back()->withErrors([
                    'new_password' => 'Новый пароль должен отличаться от текущего.'
                ])->withInput($request->except(['new_password', 'new_password_confirmation']));
            }

            $request->validate([
                'new_password' => 'required|string|min:6|confirmed',
                'new_password_confirmation' => 'required',
            ], [
                'new_password.required' => 'Новый пароль обязателен для заполнения.',
                'new_password.min' => 'Пароль должен содержать минимум 6 символов.',
                'new_password.confirmed' => 'Пароли не совпадают.',
                'new_password_confirmation.required' => 'Подтверждение пароля обязательно.',
            ]);
            
            $userData['password'] = Hash::make($request->new_password);
        }

        // Обновляем аватар, если он был загружен вместе с другими данными
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'avatar.required' => 'Файл аватара обязателен для загрузки.',
                'avatar.image' => 'Файл должен быть изображением.',
                'avatar.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif.',
                'avatar.max' => 'Размер файла не должен превышать 2MB.',
            ]);
            
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }
            $image = $request->file('avatar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $avatarPath = $image->storeAs('avatars', $imageName, 'public');
            $userData['avatar'] = $avatarPath;
        }

        // Обновляем только те поля, которые пришли
        if (!empty($userData)) {
            $user->update($userData);
            return back()->with('success', 'Профиль обновлён!');
        }

        return back()->with('info', 'Нет данных для обновления');
    }
}