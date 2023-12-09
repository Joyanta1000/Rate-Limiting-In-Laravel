### Intructions of laravel 10 rate limiter
https://laravel.com/api/10.x/Illuminate/Cache/RateLimiter.html

## Middleware to handle
**You have to create middleware**

## Code in middleware

    public function handle(Request $request, Closure $next): Response
    {
        if (RateLimiter::tooManyAttempts('send-message:'.$request->email, $perMinute = 5)) {
            $seconds = RateLimiter::availableIn('send-message:'.$request->email);
            return Response(['message' => 'You may try again in '.$seconds.' seconds.']);
        }
        RateLimiter::hit('send-message:'.$request->email, 300);
        return $next($request);
    }

## Configuration for middleware
    
    > app/Http/kernel.php

    In middlewareAliases

    'login.attempt' => \App\Http\Middleware\LoginAttemptMiddleware::class,
