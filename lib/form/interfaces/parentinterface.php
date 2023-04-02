<?php

namespace Bx\Options\Form\Interfaces;


interface ParentInterface extends UiElementInterface, \Iterator
{
    /**
     * @param UiElementInterface $element
     * @return $this
     */
    public function addChild(UiElementInterface $element): self;

    /**
     * @return array
     */
    public function getChildren(): array;
}
