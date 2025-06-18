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
        $sql = "
            SELECT
                items.id, items.name, completed, assignee, users.name as assigneeName
            FROM
                items
            LEFT JOIN
                users
            ON
                assignee = users.id";
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

    /**
     * Renders assign view.
     * 
     * @param array $routeParams Route parameters
     * 
     * @return void
     */
    public function assignView(array $routeParams = []): void
    {
        try {
            $itemId = $routeParams[":itemId"];
            $sql = "SELECT id, name FROM items WHERE id = $itemId";
            $query = DB::instance()->query($sql);

            $record = $query->fetch(PDO::FETCH_ASSOC);

            if (!$record) {
                exitApp(code: 404, message: "Record not found");
            }

            $users = "SELECT id, name FROM users";
            $query = DB::instance()->query($users);
            $users = $query->fetchAll(PDO::FETCH_ASSOC);

            renderView("list.assign", "layout", [
                "title" => "Roomracoon list - Assign",
                "users" => $users,
                "itemId" => $record['id'],
            ]);
        }catch(Exception $e) {
            exitApp(code: 500, message: "Failed to fetch record");
        }
    }

    /**
     * Assigns an item to a user.
     * 
     * @param array $routeParams Route parameters
     * 
     * @return void
     */
    public function assignItem(array $routeParams = []): void
    {
        $itemId = $routeParams[":itemId"];
        $userId = $routeParams[":userId"];
        $itemSql = "SELECT id, name FROM items WHERE id = $itemId";
        $query = DB::instance()->query($itemSql);

        $record = $query->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            exitApp(code: 404, message: "Record not found");
        }

        $userSql = "SELECT id FROM users WHERE id = $userId";
        $query = DB::instance()->query($userSql);

        if (!$query->fetch(PDO::FETCH_ASSOC)) {
            exitApp(code: 404, message: "User not found");
        }

        $sql = "UPDATE items SET assignee = '". $userId . "' WHERE id = " . $routeParams[":itemId"];
        try {
            DB::instance()->query($sql);
            redirect("/list");
        }catch(Exception $e) {
            exitApp(code: 500, message: "Failed to assign item to user");
        }
    }

}