<?php

declare(strict_types = 1);

namespace App\Forms\Validators;

interface FormValidatorInterface
{
    public function validateEmail();
    public function sanitizeText();
    public function removeUnwantedChars(string $text);
}