<?php

namespace Bx\Options\Form;

use Bx\Options\Form\Element\ParentElement;
use Bx\Options\Form\Element\Tab;
use Bx\Options\Form\Element\Tabs;
use Bx\Options\Form\Interfaces\AttributeInterface;
use Bx\Options\Form\Interfaces\HasAttributeInterface;
use Bx\Options\Form\Traits\AttributeTrait;

class TabbedForm extends ParentElement implements HasAttributeInterface
{
    use AttributeTrait;

    private array $attributes = [];


    public function __construct($action, Tab ...$tabs)
    {
        $uiTabs = new Tabs(...$tabs);
        $this->attributes[] = Attribute::init("action", $action);
        $this->addChild($uiTabs);
    }

    /**
     * @return string
     */
    public function getElementName(): string
    {
        return ElementName::FORM;
    }

}
