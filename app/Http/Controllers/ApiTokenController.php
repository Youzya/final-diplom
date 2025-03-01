<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiTokenController extends Controller
{
    public function createToken(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'device_name' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json(['err' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['err' => 'Пользователь не найден или пароль неверен.'], 401);
        }

        $token = $user->createToken($request->device_name);
        return response()->json(['token' => $token->plainTextToken], 200);
    }
}
