<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoActiveMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if(!$user){
            return redirect()->route('login');
        }
        $membership = $user->membership()->where('status', 'active')->first();

        if($membership){
            return redirect()->route('colocation.index');
        }

        return $next($request);
    }
}
