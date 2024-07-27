<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(Request $request) {
        $payload = [
            "email" => $request->email,
            "password" => $request->password
        ];

         $user = User::firstWhere("email", $payload["email"]);

         if ($user) {
            if (Hash::check($payload["password"], $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;

                return response()->json([
                    "message" => "Login berhasil",
                    "user" => $user,
                    "token" => $token
                ], 200);
            } else {
                return response()->json([
                    "message" => "Password salah"
                ], 401);
            }
         } else {
            return response()->json([
                "message" => "Akun tidak terdaftar"
            ], 404);
         }
    }

    function register(Request $request) {
        $payload = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password
        ];

        Hash::make($payload["password"]);

        User::create($payload);
    }

    function authProfile() {
        $user = Auth::user();

        return response()->json([
            "user" => $user
        ], 200);
    }
}
