<?php

namespace Bx\Options\Form\Validator;

interface ValidatorInterface
{
    public function validate($value): bool;

    public function getValidateErrorMessage(): string;
}