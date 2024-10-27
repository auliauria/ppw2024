<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->role === 'user') {
            return redirect()->route('welcome')->withError('Anda tidak memiliki akses ke halaman admin!');
        }
        return $next($request);
    }
    
}
