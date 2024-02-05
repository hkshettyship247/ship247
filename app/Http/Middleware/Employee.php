<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Employee
{
   
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user() && auth()->user()->role_id == 3) {
            return $next($request);
        }
        return $next($request);
    }
}
