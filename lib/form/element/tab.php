<?php

namespace Bx\Options\Form\Element;

use Bx\Options\Form\Attribute;
use Bx\Options\Form\ElementName;
use Bx\Options\Form\Interfaces\AttributeInterface;
use Bx\Options\Form\Interfaces\HasAttributeInterface;
use Bx\Options\Form\Interfaces\UiElementInterface;
use Bx\Options\Form\Traits\AttributeTrait;

class Tab extends ParentElement
{

    use AttributeTrait;

    public function __construct($tabName, UiElementInterface ...$elements)
    {
        $this->attributes[] = Attribute::init("name", $tabName);
        foreach ($elements as $element) {
            $this->addChild($element);
        }
    }


    public function getElementName(): string
    {
        return ElementName::TAB;
    }
}