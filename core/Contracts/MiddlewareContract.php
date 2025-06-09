<?php

namespace Roomracoon\Core\Contracts;

use Closure;
use Roomracoon\Core\Request;

/**
 * Interface MiddlewareContract
 * 
 * Defines the structure of a middleware.
 */

interface MiddlewareContract
{

    /**
     * Handles the middleware logic.
     * 
     * @param Roomracoon\Core\Request Request $request Request class passed to the next middleware.
     * @param Closure $next Next callable function.
     * 
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed;

}