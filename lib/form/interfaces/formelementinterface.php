<?php

namespace Bx\Options\Form\Interfaces;

interface FormElementInterface extends UiElementInterface, HasAttributeInterface
{

    public function getName(): string;

    public function getLabel(): string;

    public function getValue();
}
