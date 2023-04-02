<?php

namespace Bx\Options\Form\Element;

use Bx\Options\Form\Interfaces\AttributeInterface;
use Bx\Options\Form\Interfaces\HasAttributeInterface;
use Bx\Options\Form\Interfaces\UiElementInterface;
use Bx\Options\Form\Render\RenderInterface;
use Bx\Options\Form\Traits\AttributeTrait;

abstract class BaseElement implements UiElementInterface, HasAttributeInterface
{
    use AttributeTrait;


    /**
     * @param RenderInterface $render
     * @return string
     */
    public function render(RenderInterface $render): string
    {
        return $render->getContent($this);
    }

    /**
     * @return string
     */
    abstract public function getElementName(): string;

}