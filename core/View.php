<?php

namespace Roomracoon\Core;

/**
 * Class View
 * 
 * Basic view class.
 * 
 * @package Roomracoon\Core
 */

use Exception;
use Roomracoon\Core\Contracts\ViewHandlerContract;

class View implements ViewHandlerContract
{

    /**
     * View construct
     * 
     * @param string $layoutFilePath Layout file path
     * @param string $viewFilePath View file path
     * @param array $data Array of data that need to be converted to variables.
     * 
     * @return Roomracoon\Core\Contracts\ViewHandlerContract
     */
    public function __construct(private string $viewFilePath, private ?string $layoutFilePath = null, private array $data = []) {}

    /**
     * Renders specified view.
     * 
     * @param string $viewFilePath View file path.
     * @param array $data Array of data that need to be converted to variables.
     * @throws Exception
     * 
     * @return void
     */
    public function render(?string $viewFilePath = null, array $data = []): void
    {
        try {
            if ($viewFilePath) {
                $this->viewFilePath = $viewFilePath;
            }

            $viewFile = getViewsPath($this->viewFilePath) . ".php";
            $layoutFile = null;

            if (!file_exists($viewFile)) {
                throw new Exception("View file `$viewFile` does not exist");
            }

            if (count($data) > 0) {
                $this->data = $data;
            }

            // Store file content here. Don't output it yet.
            $viewContent = $this->loadFileData($viewFile);

            if ($this->layoutFilePath) {
                $layoutFile = getViewsPath($this->layoutFilePath) . ".php";
                if (!file_exists($layoutFile)) {
                    throw new Exception("Layout view file `$layoutFile` does not exist");   
                }
            }

            if ($layoutFile) {
                $layoutContent = str_replace("{{content}}", $viewContent, $this->loadFileData($layoutFile));
                echo $layoutContent;
            }else{
                echo $viewContent;
            }
        }catch(Exception $e) {
            exitApp(code: 500, message: $e->getMessage());
        }
    }

    /**
     * Sets the layout to use.
     * 
     * @param string $layoutFilePath
     * 
     * @return void
     */
    public function useLayout(string $layoutFilePath): ViewHandlerContract
    {
        $this->layoutFilePath = $layoutFilePath;
        return $this;
    }

    /**
     * Use output buffer to get the file contents.
     * 
     * @param string $file File to fetch content from.
     * 
     * @return string
     */
    private function loadFileData(string $file): string
    {
        ob_start();
        extract($this->data, EXTR_SKIP);
        require $file;
        return ob_get_clean();
    }

}