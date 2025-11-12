<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Jika belum login atau bukan admin -> redirect atau abort
        if (!$user || $user->role !== 'admin') {
            // opsi redirect ke home dengan pesan
            return redirect()->route('home')->with('error', 'Anda tidak punya akses ke area admin.');
            // atau abort(403);
        }

        return $next($request);
    }
}
