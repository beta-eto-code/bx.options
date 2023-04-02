<?php

namespace Bx\Options\Form\Element;

use Bx\Options\Form\ElementName;

class Tabs extends ParentElement
{
    public function __construct(Tab ...$tab)
    {
        foreach ($tab as $item) {
            $this->addChild($item);
        }
    }

    /**
     * @return string
     */
    public function getElementName(): string
    {
        return ElementName::TABS;
    }
}