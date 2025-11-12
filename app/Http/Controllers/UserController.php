<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan dashboard untuk user biasa.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // jika ingin pass data ringkas ke view
        return view('user.dashboard', compact('user'));
    }
}
