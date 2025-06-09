<?php

namespace Roomracoon\Core;

/**
 * Class Request
 * 
 * Basic request class.
 * 
 * @package Roomracoon\Core
 */

class Request
{

    /**
     * Represents the $_SERVER global variable.
     * 
     * @var array
     */
    private array $server;

    /**
     * Represents the $_REQUEST global variable.
     * 
     * @var array
     */
    private array $request;

    /**
     * The request method.
     * 
     * @var string
     */
    public string $method;

    /**
     * Stores the request uri path.
     * 
     * @var string
     */
    public string $path;

    /**
     * Stores post data.
     * 
     * @var string
     */
    public object $body;

    /**
     * Request construct
     */
    public function __construct()
    {
        $this->server = $_SERVER;
        $this->request = $_REQUEST;
        $this->method = $this->server['REQUEST_METHOD'];
        $this->path = parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
        $this->body = (Object) $_POST;
    }

}