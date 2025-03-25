<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    function login(Request $requst){
        $validateData = $requst->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $validateData['email'])->first();

        if(!$user){
            throw ValidationException::withMessage([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        if(!Hash::check($validateData['password'], $user->password)){
            throw ValidationException::withMessage([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        $token =  $user->createToken('user-api-token')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    function logout(Request $requst){
        $requst->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
