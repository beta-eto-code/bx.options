<?php

namespace Bx\Options\Form\Element\UI;

use Bx\Options\Form\Attribute;
use Bx\Options\Form\Element\ParentElement;
use Bx\Options\Form\ElementName;
use Bx\Options\Form\Interfaces\UiElementInterface;
use Bx\Options\Form\Traits\AttributeTrait;

class Collapse extends ParentElement
{

    use AttributeTrait;

    public function __construct($collapseName, UiElementInterface ...$elements)
    {
        $this->attributes[] = Attribute::init("name", $collapseName);
        foreach ($elements as $element) {
            $this->addChild($element);
        }
    }


    public function getElementName(): string
    {
        return ElementName::COLLAPSE;
    }
}
