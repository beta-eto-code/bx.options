<?php

namespace Bx\Options\Form\Interfaces;

interface HasAttributeInterface
{

    public function setAttribute(AttributeInterface $attribute):self;

    public function getAttributes():array;

    public function getAttribute(string $name): AttributeInterface;

    public function hasAttribute(string $name): bool;
}
