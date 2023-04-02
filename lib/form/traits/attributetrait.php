<?php

namespace Bx\Options\Form\Traits;

use Bx\Options\Form\Attribute;
use Bx\Options\Form\Interfaces\AttributeInterface;
use Bx\Options\Form\Interfaces\HasAttributeInterface;

trait AttributeTrait {

    private array $attributes = [];

    /**
     * @param AttributeInterface $attribute
     * @return $this
     */
    public function setAttribute(AttributeInterface $attribute): HasAttributeInterface
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $name): AttributeInterface
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->getKey() === $name) {
                return $attribute;
            }
        }
        return Attribute::init("", null);
    }

    public function hasAttribute(string $name): bool
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->getKey() === $name) {
                return true;
            }
        }
        return false;
    }
}