<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MiddlewarePetugas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Silakan login terlebih dahulu'
            ]);
        }

        // Jika user bukan petugas
        if (Auth::user()->role !== 'petugas') {
            return redirect()->back()->withErrors([
                'akses' => 'Akses anda tidak sah'
            ]);
        }

        // Jika lolos semua pemeriksaan
        return $next($request);
    }
}
