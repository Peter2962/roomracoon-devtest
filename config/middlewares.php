<?php

return [
    "auth" => App\Middlewares\AuthMiddleware::class,
    "session" => App\Middlewares\SessionMiddleware::class,
    "example" => App\Middlewares\ExampleMiddleware::class,
];