<?php

namespace Bx\Options\Form\Element;

use Bx\Options\Form\Interfaces\FormElementInterface;
use Bx\Options\Form\Interfaces\UiElementInterface;
use Bx\Options\Form\Interfaces\ValidatedInterface;
use Bx\Options\Form\Render\RenderInterface;
use Bx\Options\Form\Traits\AttributeTrait;
use Bx\Options\Form\Validator\ValidatorInterface;

abstract class BaseField implements UiElementInterface, FormElementInterface, ValidatedInterface
{
    protected string $name;

    protected $value;

    protected string $label;

    use AttributeTrait;

    /**
     * @var ValidatorInterface|null
     */
    private ?ValidatorInterface $validator = null;

    abstract public function getElementName(): string;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value ?? '';
    }



    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @param RenderInterface $render
     * @return string
     */
    public function render(RenderInterface $render): string
    {
        return $render->getContent($this);
    }

    public function setValidator(ValidatorInterface $validator): ValidatedInterface
    {
        $this->validator = $validator;
        return $this;
    }

    public function validate(): bool
    {
        if ($this->validator === null) {
            return true;
        }

        return $this->validator->validate($this->getValue());
    }

    public function getValidateErrorMessage(): string
    {
        if ($this->validator === null) {
            return '';
        }

        return $this->validator->getValidateErrorMessage();
    }
}
