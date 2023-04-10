<?php

namespace Bx\Options\Form\Element\UI;

use Bx\Options\Form\Element\ParentElement;
use Bx\Options\Form\ElementName;

class Collapses extends ParentElement
{
    public function __construct(Collapse ...$collapse)
    {
        foreach ($collapse as $item) {
            $this->addChild($item);
        }
    }

    /**
     * @return string
     */
    public function getElementName(): string
    {
        return ElementName::COLLAPSES;
    }
}
