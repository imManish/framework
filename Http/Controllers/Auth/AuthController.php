<?php

namespace App\Http\Controllers\Auth;

use App\Core\Controller;
use App\Core\Request;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $this->layout('_auth');
        if($request->method() === 'post'){
            var_dump($request->all());
        }

        return $this->view('auth/login');
    }

    public function register()
    {
        $this->layout('_auth');
        return $this->view('auth/register');
    }
}