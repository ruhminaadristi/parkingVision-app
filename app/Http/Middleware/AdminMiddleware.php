<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Tambahkan logging
        Log::info('Admin middleware check', [
            'user' => Auth::user(),
            'is_authenticated' => Auth::check(),
            'is_admin' => Auth::check() ? Auth::user()->is_admin : false
        ]);

        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
