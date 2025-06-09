<?php

return [
    "environment" => "local", // accepts local or production
    "routerHandler" => Roomracoon\Core\Router::class,
    "viewHandler" => Roomracoon\Core\View::class,
    "viewsPath" => "res",
    "viewFileExtension" => ".php",
];