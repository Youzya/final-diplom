<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        // Логируем все входящие данные
        \Log::info('Login attempt', $request->all());

        // Посмотрим, какие ключи реально передаются
        if (!$request->has(['email', 'password'])) {
            return redirect()->back()->withErrors(['email' => 'Форма передает неправильные данные.']);
        }

        // Получаем email и пароль
        $email = $request->input('email');
        $password = $request->input('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()->withErrors(['email' => 'Введите email и пароль.']);
        }

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('/admin/index');
        }

        return redirect()->back()->withErrors(['email' => 'Пользователь не найден или пароль неверен.']);
    }

    public function form()
    {
        return view('admin.login');
    }

    public function adminLogin()
    { 
        return view('auth.app_login');
    }
}
