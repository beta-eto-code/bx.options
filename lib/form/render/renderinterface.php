<?php

namespace Bx\Options\Form\Render;

use Bx\Options\Form\Interfaces\UiElementInterface;

interface RenderInterface
{
    /**
     * @param  UiElementInterface $element
     * @return string
     */
    public function getContent(UiElementInterface $element): string;
}
