<?php

declare(strict_types = 1);

namespace App\Forms\InputTypes;

/**
 * Foundation class for input elements (HTML)
 */

abstract class AbstractInputType
{
    /**
     * @var $inpupt HTML input element
     */
    protected $input;

    public function __construct()
    {
        $this->input = '';
    }
    /**
     * @return $input HTML element
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return string html code (opening)
     */
    public function inputStart(): string 
    {
        return sprintf("<input");
    }
    /**
     * @return string closing html tag
     */
    public function inputEnd(): string
    {
        return sprintf(">");
    }

    /**
     * Adds label to input (optional)
     */
    public function addLabel(
                            string $text, 
                            string $labelFor = '', 
                            string $cssClasses = ''): string
    {
        return sprintf("<label for='%s' class='%s' >%s</label>", $labelFor, $cssClasses, $text);
    }
}