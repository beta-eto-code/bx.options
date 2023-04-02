<?php

namespace Bx\Options\Form\Interfaces;

use Bx\Options\Form\Validator\ValidatorInterface;

interface ValidatedInterface
{
    public function setValidator(ValidatorInterface $validator): ValidatedInterface;

    public function validate(): bool;

    public function getValidateErrorMessage(): string;
}