<?php

namespace Bx\Options\Form\Interfaces;

use Bx\Options\Form\Field\ValidatorInterface;

interface ValidatableInterface
{
    /**
     * @param ValidatorInterface $validator
     * @return $this
     */
    public function addValidator(ValidatorInterface $validator): self;

    /**
     * @return bool
     */
    public function validate(): bool;

    /**
     * @return string
     */
    public function getValidateErrorMessage():string;
}
