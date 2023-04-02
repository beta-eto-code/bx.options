<?php

namespace Bx\Options\Form;

use Bx\Options\Form\Interfaces\AttributeInterface;

class Attribute implements AttributeInterface
{
    /** @var string  */
    private string $key;

    /** @var mixed */
    private $value;

    public static function init(string $key, $value): AttributeInterface
    {
        $self = new self();
        $self->key = $key;
        $self->value = $value;
        return $self;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
