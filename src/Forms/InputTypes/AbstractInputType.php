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
    public function inputStart()
    {
        return sprintf("<input");
    }
    public function inputEnd()
    {
        return  sprintf(">");
    }
}