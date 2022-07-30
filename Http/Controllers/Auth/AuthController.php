<?php

namespace App\Http\Controllers\Auth;

use App\Core\Http\Request;
use App\Core\Routing\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request): array|bool|string
    {
        $this->layout('_auth');
        $user = new User();
        if ('post' === $request->method()) {
            $user->load($request->all());
            if ($user->validate() && $user->register()) {
                return 'success';
            }

            return $this->view('auth/login', [
                'model' => $user,
            ]);
        }

        return $this->view('auth/login', [
            'model' => $user,
        ]);
    }

    public function register(): array|bool|string
    {
        $this->layout('_auth');

        return $this->view('auth/register');
    }
}
