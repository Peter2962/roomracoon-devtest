<?php

namespace App\Controllers;

use Roomracoon\Core\DB;
use Roomracoon\Core\BaseController;

/**
 * Class HomeController
 * 
 * Home controller.
 * 
 * @package App\Controllers
 */

class HomeController extends BaseController
{

    /**
     * Returns index view.
     * 
     * @return void
     */
    public function index(): void
    {
        renderView("home.index", "layout", [
            "title" => "Welcome to Roomracoon shopper"
        ]);
    }

}