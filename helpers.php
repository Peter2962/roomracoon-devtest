<?php

/**
 * Returns a configuration array defined in a file.
 * 
 * @param name - Name of configuration file.
 * 
 * @return mixed
 */
function getConfig(string $name, string $value = null): mixed
{
    $configDirectory = __DIR__ . "/config/";
    $configArray = require $configDirectory . $name . ".php" ?? throw new Exception("A");

    if (!$value) {
        return $configArray;
    }

    $valueArray = explode(".", $value);
    foreach ($valueArray as $val) {
        if (!isset($configArray[$val])) {
            return null;
        }
        $configArray = $configArray[$val];
    }

    return $configArray;
}

/**
 * Returns instance of Roomracoon\Core\Request
 * 
 * @return Roomracoon\Core\Request
 */
function request(): Roomracoon\Core\Request
{
    return new Roomracoon\Core\Request();
}

/**
 * Exists the app with the http response code specified
 * 
 * @param $code int
 * @param $message string | null
 * 
 * @return void
 */
function exitApp(int $code, ?string $message = null): void
{
    http_response_code($code);
    echo $message;
    exit;
}

/**
 * Returns an environment variable
 * 
 * @param $name string
 * @param $fallbackValue null
 * 
 * @return mixed
 */
function env(string $name, $fallbackValue = null): mixed
{
    return $_ENV[$name] ?? $fallbackValue;
}

/**
 * Returns view directory path
 * 
 * @param string $appendPath Path that can be appended
 * 
 * @return string
 */
function getViewsPath(?string $appendPath = null): string
{
    $path = null;
    if ($appendPath) {
        $appendPathArray = explode(".", $appendPath);
        $path = DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $appendPathArray);
    }

    return getConfig(name: "app", value: "viewsPath") . $path;
}

/**
 * Renders view
 * 
 * @param string $layout Path of view file to render.
 * @param string $view Path of view file to render.
 * @param array $data Array of data that need to be converted to variables.
 * 
 * @return void
 */
function renderView(string $view, ?string $layout = null, array $data = []): void
{
    (new  Roomracoon\Core\View(viewFilePath: $view, layoutFilePath: $layout, data: $data))->render();
}

/**
 * Redirects page to given path.
 * 
 * @param string $path Path to redirect to.
 * 
 * @return void
 */
function redirect(string $path)
{
    return header("Location: $path");
}