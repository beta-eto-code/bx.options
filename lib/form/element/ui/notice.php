<?php

namespace Bx\Options\Form\Element\UI;

use Bx\Options\Form\Attribute;
use Bx\Options\Form\Element\BaseElement;
use Bx\Options\Form\ElementName;

class Notice extends BaseElement
{
    public function __construct($title, $text, $type = 'info')
    {
        $this->setAttribute(Attribute::init('title', $title));
        $this->setAttribute(Attribute::init('text', $text));
        $this->setAttribute(Attribute::init('type', $type));
    }

    /**
     * @return string
     */
    public function getElementName(): string
    {
        return ElementName::NOTICE;
    }
}