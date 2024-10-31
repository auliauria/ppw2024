<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan levelnya adalah 'admin'
        if (Auth::check() && Auth::user()->level === 'admin') {
            return $next($request); // Jika admin, lanjut ke request berikutnya
        }
        // Jika bukan admin, redirect ke logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('error', 'Anda bukan admin!');
    }
    
}
