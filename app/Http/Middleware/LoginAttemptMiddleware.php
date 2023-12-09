<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class LoginAttemptMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (RateLimiter::tooManyAttempts('send-message:'.$request->email, $perMinute = 5)) {
            $seconds = RateLimiter::availableIn('send-message:'.$request->email);
         
            return Response(['message' => 'You may try again in '.$seconds.' seconds.']);
        }
         
        RateLimiter::hit('send-message:'.$request->email, 300);
       
        return $next($request);
    }
}
