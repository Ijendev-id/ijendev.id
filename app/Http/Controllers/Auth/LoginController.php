<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    // Jika kamu punya $redirectTo tetap, tapi override authenticated untuk custom logic:
    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard'); // route admin
        }

        // default ke halaman user
        return redirect()->route('user.dashboard');
    }
}
