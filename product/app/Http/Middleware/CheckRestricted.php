<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRestricted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $collection = \App\Models\Collection::find($request->route('id'));

        if ($collection && $collection->is_restricted && !session()->has('user')) {
            return redirect()->route('login')
                ->with('error', 'Harus login!');
        }

        return $next($request);
    }
}