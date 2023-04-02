<?php

namespace Bx\Options\Form\Element\UI;

use Bx\Options\Form\Attribute;
use Bx\Options\Form\Element\BaseElement;
use Bx\Options\Form\ElementName;

class Divider extends BaseElement
{
    public function __construct(string $title)
    {
        $this->setAttribute(Attribute::init("title", $title));
    }

    /**
     * @return string
     */
    public function getElementName(): string
    {
        return ElementName::UI_DIVIDER;
    }
}
