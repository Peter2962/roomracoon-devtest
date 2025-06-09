<?php

namespace Roomracoon\Core;

use Exception;
use Roomracoon\Core\BaseController;
use Roomracoon\Core\Contracts\MiddlewareContract;
use Roomracoon\Core\Contracts\RouterHandlerContract;

/**
 * Class Router
 * 
 * Basic router class
 * 
 * @package Roomracoon\Core 
 */

class Router implements RouterHandlerContract
{

    /**
     * Stores route segments.
     * 
     * @var array
     */
    private array $routeSegments = [];

    /**
     * Handles basic routing
     * 
     * @return mixed
     */
    public function handle(): mixed
    {
        try {
            $requestMethod = request()->method;
            $requestMethodRoutes = getConfig(name: "routes", value: $requestMethod);
            $paths = array_keys($requestMethodRoutes);
            $requestPath = request()->path;
            $matchedRoute = null;

            foreach($paths as $path) {
                if (!$this->matches(path: $path, uri: $requestPath)) {
                    continue;
                }

                $matchedRoute = $requestMethodRoutes[$path];
                break;
            }

            if (!$matchedRoute) {
                exitApp(code: 404, message: "Route [`$requestPath`] not found");
            }

            return $this->callAction(route: $matchedRoute);
        }catch(Exception $e) {
            exitApp(code: 500, message: $e->getMessage());
        }
    }

    /**
     * Check if given path matches uri path
     * 
     * @param string $path Route path 
     * @param string $uri Uri path
     * 
     * @return bool
     */
    private function matches(string $path, string $uri): bool
    {
        $pathSplit = explode("/", trim($path, "/"));
        $uriSplit = explode("/", trim($uri, "/"));

        if (count($pathSplit) != count($uriSplit)) {
            return false;
        }

        foreach($pathSplit as $i => $segment) {
            if (preg_match("/:[a-zA-Z_][a-zA-Z0-9_]*/", $segment)) {
                $pathSplit[$i] = $uriSplit[$i];
                $this->routeSegments[$segment] = $uriSplit[$i];
            }
        }

        if (implode("/", $pathSplit) != implode("/", $uriSplit)) {
            return false;
        }

        return true;
    }

    /**
     * Returns the controller and method to call
     * 
     * @param array $route Route that is matched with uri
     * 
     * @return mixed
     */
    private function callAction(array $route): mixed
    {
        $actionKeys = array_intersect(array_keys($route), ["in", "call", "use"]);

        if (count($actionKeys) != 3) {
            throw new Exception("Malformed route options in config");
        }

        $controller = $route["in"];
        
        if (!class_exists($controller)) {
            throw new Exception("Route target class [`$controller`] does not exist");
        }

        $method = $route["call"];

        if (!method_exists((new $controller), $route["call"])) {
            throw new Exception("Method [`$method`] does not exist in target controller");
        }

        if (!is_subclass_of((new $controller), BaseController::class)) {
            throw new Exception("`$controller` must extend Roomracoon\Core\BaseController");
        }

        return $this->dispatch(
            controller: new $controller,
            method: $method,
            routeMiddlewares: $route["use"]
        );
    }

    /**
     * Dispatches the registered action in a middleware wrapper.
     * 
     * @param Roomracoon\Core\BaseController $controller Registered controller to call a method from.
     * @param string $method Method to call from registered controller.
     * @param array $routeMiddlewares An array of middlewares registered for the route.
     * 
     * @return mixed
     */
    private function dispatch(BaseController $controller, string $method, array $routeMiddlewares = []): mixed
    {
        $registerdMiddlewares = getConfig(name: "middlewares");
        $registeredRouteMiddlewares = array_intersect_key($registerdMiddlewares, array_flip($routeMiddlewares));
        $next = array_reduce(array_reverse($registeredRouteMiddlewares), function($next, $current) {
            
            $middleware = new $current();
            
            if (!$middleware instanceof MiddlewareContract) {
                throw new Exception("`$current` must implement MiddlewareContract");
            }

            return function() use ($middleware, $next) {
                return $middleware->handle(request(), $next);
            };

        }, function() use ($controller, $method) {
            return $controller->$method($this->routeSegments);
        });

        return $next();
    }

}