<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function auth(Request $request) {
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'access_token' => $token,
                    'token_type'   => 'Bearer',
                ],
                'message' => 'Autenticação realizada com sucesso'
            ], Response::HTTP_OK);
        }
        return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }
}
