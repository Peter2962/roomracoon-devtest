<?php

namespace Roomracoon\Core\Contracts;

/**
 * Interface ViewHandlerContract
 * 
 * Defines the required structure of a view handler.
 */

interface ViewHandlerContract
{

    /**
     * Sets the layout to use.
     * 
     * @param string $layout Layout file to be rendered.
     * 
     * @return void
     */
    public function useLayout(string $layout): ViewHandlerContract;

    /**
     * Renders the given view.
     * 
     * @param string $layout View file to be rendered.
     * 
     * @return void
     */
    public function render(string $view): void;

}