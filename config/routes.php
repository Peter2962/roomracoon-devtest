<?php

return [
    "GET" => [
        "/" => [
            "in" => App\Controllers\HomeController::class,
            "call" => "index",
            "use" => ["example"],
        ],
        "/list" => [
            "in" => App\Controllers\ListController::class,
            "call" => "index",
            "use" => []
        ],
        "/list/new" => [
            "in" => App\Controllers\ListController::class,
            "call" => "addView",
            "use" => []
        ],
        "/list/edit/:itemId" => [
            "in" => App\Controllers\ListController::class,
            "call" => "editView",
            "use" => []
        ],
    ],
    "POST" => [
        "/list/add" => [
            "in" => App\Controllers\ListController::class,
            "call" => "createItem",
            "use" => []
        ],
        "/list/delete/:itemId" => [
            "in" => App\Controllers\ListController::class,
            "call" => "deleteItem",
            "use" => []
        ],
        "/list/mark/:itemId" => [
            "in" => App\Controllers\ListController::class,
            "call" => "completeItem",
            "use" => []
        ],
        "/list/update/:itemId" => [
            "in" => App\Controllers\ListController::class,
            "call" => "updateItem",
            "use" => []
        ],
    ],
];