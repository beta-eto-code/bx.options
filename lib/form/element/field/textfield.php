<?php

namespace Bx\Options\Form\Element\Field;

use Bx\Options\Form\Element\BaseField;
use Bx\Options\Form\ElementName;

class TextField extends BaseField
{

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getElementName(): string
    {
        return ElementName::TEXT_FIELD;
    }
}
