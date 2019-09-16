<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    private function auth()
    {
        return Auth::guard('api');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = $this->auth()->attempt($credentials)) {
            return response(Lang::get('auth.failed'), 401);
        }

        return $this->token($token);
    }

    public function me()
    {
        $this->auth()->user();
    }

    public function refresh()
    {
        $artiste = $this->auth()->refresh();

        return $this->token($artiste);
    }

    public function logout()
    {
        $this->auth()->logout();
        return $this->respondWithSuccess('Logout successful');
    }

    public function token($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth()->factory()->getTTL() * 60
        ];
    }
}
