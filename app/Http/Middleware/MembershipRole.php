<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MembershipRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , ... $roles): Response
    {
        $user = $request->user();
        if (!$user){
            return redirect()->route('login');
        }
        if(!$user->membership){
            return redirect()->route('colocation.create');
        }
        if (!empty($roles) && !in_array($user->membership->role, $roles)){
            return redirect()->route('home');
        }
        return $next($request);
    }
}
