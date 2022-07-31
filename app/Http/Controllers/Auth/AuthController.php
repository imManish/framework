<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Bundle\Http\Request;
use Bundle\Routing\Controller;
//use Bundle\Http\Controllers\Auth\view;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return array|bool|string
     */
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

    /**
     * @return array|bool|string
     */
    public function register(): array|bool|string
    {
        $this->layout('_auth');

        /** @var view $this */
        return $this->view('auth/register');
    }
}
