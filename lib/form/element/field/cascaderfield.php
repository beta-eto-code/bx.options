<?php

namespace Bx\Options\Form\Element\Field;

use Bx\Options\Form\Attribute;
use Bx\Options\Form\Element\BaseField;
use Bx\Options\Form\ElementName;

class CascaderField extends BaseField
{

    public function __construct(string $name, string $label, array $options, $multiple = false, $collapseTags = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->setAttribute(Attribute::init("options", $options));
        $this->setAttribute(Attribute::init("multiple", $multiple));
        $this->setAttribute(Attribute::init("collapseTags", $collapseTags));
    }

    /**
     * @return string
     */
    public function getElementName(): string
    {
        return ElementName::CASCADER_FIELD;
    }
}
