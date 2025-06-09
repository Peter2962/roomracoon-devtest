<?php

namespace Roomracoon\Core\Contracts;

/**
 * Interface RouterHandlerContract
 * 
 * Defines the structure of the router handler.
 */

interface RouterHandlerContract
{
    /**
     * Executes the routing logic.
     * 
     * @return mixed
     */
    public function handle(): mixed;

}