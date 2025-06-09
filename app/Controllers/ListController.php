<?php

namespace App\Controllers;

use PDO;
use Roomracoon\Core\DB;
use Roomracoon\Core\BaseController;

/**
 * Class ListController
 * 
 * List controller.
 * 
 * @package App\Controllers
 */

class ListController extends BaseController
{

    /**
     * Returns index view.
     * 
     * @return void
     */
    public function index(): void
    {
        $list = [];
        $sql = "SELECT id, name, completed FROM items";
        $records = DB::instance()->query($sql);
        $list = $records->fetchAll(PDO::FETCH_ASSOC);

        renderView("list.index", "layout", [
            "title" => "Roomracoon shopping list",
            "list" => $list
        ]);
    }

    /**
     * Renders item add view.
     * 
     * @return void
     */
    public function addView(): void
    {
        renderView("list.add", "layout", [
            "title" => "Roomracoon shopping list - Add new"
        ]);
    }

    /**
     * Creates a new item.
     * 
     * @return void
     */
    public function createItem(): void
    {
        try {
            $params = request()->body;
            $db = DB::instance();

            $sql = 'INSERT INTO items (name) VALUES ("'. $params->name . '")';
            $db->exec($sql);

            redirect("/list");
        }catch(Exception $e) {
            exitApp(code: 500, message: "Failed to add item");
        }
    }

    /**
     * Renders edit view.
     * 
     * @param array $routeParams Route parameters
     * 
     * @return void
     */
    public function editView(array $routeParams = []): void
    {
        try {
            $itemId = $routeParams[":itemId"];
            $sql = "SELECT id, name FROM items WHERE id = $itemId";
            $query = DB::instance()->query($sql);

            $record = $query->fetch(PDO::FETCH_ASSOC);

            if (!$record) {
                exitApp(code: 404, message: "Record not found");
            }

            renderView("list.edit", "layout", [
                "title" => "Roomracoon shopping list - Edit",
                "item" => $record,
            ]);
        }catch(Exception $e) {
            exitApp(code: 500, message: "Failed to fetch record");
        }
    }

    /**
     * Updates an item.
     * 
     * @param array $routeParams Route parameters
     * 
     * @return void
     */
    public function updateItem(array $routeParams = []): void
    {
        $body = request()->body;
        $sql = "UPDATE items SET name = '". $body->name . "' WHERE id = " . $routeParams[":itemId"];
        try {
            DB::instance()->query($sql);
            redirect("/list");
        }catch(Exception $e) {
            exitApp(code: 500, message: "Failed to complete item");
        }
    }

    /**
     * Delete item.
     * 
     * @param array $routeParams Route parameters
     * 
     * @return void
     */
    public function deleteItem(array $routeParams = []): void
    {
        $sql = "DELETE FROM items WHERE id = " . $routeParams[":itemId"];
        try {
            DB::instance()->query($sql);
            redirect("/list");
        }catch(Exception $e) {
            exitApp(code: 500, message: "Failed to delete item");
        }
    }

    /**
     * Mark item as complete.
     * 
     * @param array $routeParams Route parameters
     * 
     * @return void
     */
    public function completeItem(array $routeParams = []): void
    {
        $sql = "UPDATE items SET completed = 1 WHERE id = " . $routeParams[":itemId"];
        try {
            DB::instance()->query($sql);
            redirect("/list");
        }catch(Exception $e) {
            exitApp(code: 500, message: "Failed to complete item");
        }
    }

}