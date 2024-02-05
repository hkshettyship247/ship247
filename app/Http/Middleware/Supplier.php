<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Supplier
{
   
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user() && auth()->user()->role_id == 4) {
            return $next($request);
        }
        return $next($request);
    }
}
