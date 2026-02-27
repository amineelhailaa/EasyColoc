<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotBannedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if($user->ban){
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
           return  redirect()->route('login');
        }
        return $next($request);
    }
}
