<?php

declare(strict_types = 1);

namespace App\Forms\FormBuilders;

interface FormBuilderInterface
{
    public function add(string $inputType, array $attr);
    public function addHtml(string $element);
    public function getForm(string $action);
}