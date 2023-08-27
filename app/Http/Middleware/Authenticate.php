<?php

namespace App\Http\Middleware;

use App\Http\Resources\FormatResource;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)
    {
        FormatResource::error(401, [
            "message" => ["Invalid session"]
        ]);
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if ($token = $request->cookie('session'))
        {
            $request->headers->set('Authorization', 'Bearer ' . decrypt($token));
        }
        $this->authenticate($request, $guards);

        return $next($request);
    }
}
