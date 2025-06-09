<?php

namespace Roomracoon\Core;

use Exception;
use Roomracoon\Core\Contracts\RouterHandlerContract;

/**
 * Class App
 * 
 * Main app class.
 *
 * @package Roomracoon\Core
 */

class App
{

    /**
     * Flag that tells if app has started or not.
     * 
     * @var bool
     */
    private static bool $started = false;

    /**
     * Initialize and create new app.
     * 
     * @return void
     */
    public static function createApp(): void
    {
        if (self::$started) {
            throw new Exception("Application already started");
        }

        // get registered route handler
        $routerHandlerConfig = getConfig(name: "app", value: "routerHandler");
        $routerHandler = new $routerHandlerConfig();

        if (!$routerHandler instanceof RouterHandlerContract) {
            throw new Exception("RouterHandler does not implement the correct interface");
        }

        $routerHandler->handle();

        self::$started = true;
    }

}