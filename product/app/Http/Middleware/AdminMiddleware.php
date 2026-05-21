<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user')){
            return redirect()->route('login');
        }

        if (session('user')['role_id'] != 1) {
            abort(403, 'Akses ditolak, hanya admin');
        }

        return $next($request);
    }
}
