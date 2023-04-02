<?php

namespace Bx\Options\Form;

class ValidateResult
{
    /**
     * @var bool
     */
    private bool $isValid = true;

    /**
     * @var array
     */
    private array $errors = [];


    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $error
     */
    public function addError(string $field, string $error)
    {
        $this->isValid = false;
        $this->errors[] = [
            'field' => $field,
            'error' => $error,
        ];
    }
}