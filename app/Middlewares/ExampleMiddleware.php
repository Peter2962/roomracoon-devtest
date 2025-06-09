<?php

namespace App\Middlewares;

use Closure;
use Roomracoon\Core\Request;
use Roomracoon\Core\Contracts\MiddlewareContract;

class ExampleMiddleware implements MiddlewareContract
{

    /**
     * Handles the middleware logic.
     * 
     * @see Roomracoon\Core\Contracts\MiddlewareContract
     */
    public function handle(Request $request, Closure $next): mixed
    {
        return $next($request);
    }

}