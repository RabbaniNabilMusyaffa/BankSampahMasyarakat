<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin_dash')->withErrors([
                'email' => 'Silakan login terlebih dahulu'
            ]);
        }

        // Jika user bukan petugas
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->withErrors([
                'akses' => 'Akses anda tidak sah'
            ]);
        }
        return $next($request);
    }
}
