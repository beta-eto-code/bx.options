<?php

namespace Bx\Options\Form\Interfaces;

use Bx\Options\Form\Render\RenderInterface;

interface UiElementInterface
{
    /**
     * @param RenderInterface $render
     * @return string
     */
    public function render(RenderInterface $render): string;

    public function getElementName():string;
}
