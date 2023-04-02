<?php

namespace Bx\Options\Form\Validator;


class NotEmpty implements ValidatorInterface
{
    public function validate($value): bool
    {
        return !empty($value);
    }

    public function getValidateErrorMessage(): string
    {
        return 'Значение не может быть пустым';
    }
}