<?php

namespace Bx\Options\Form;

use Bx\Options\Form\Interfaces\ParentInterface;

class TreeFilter
{

    private $filterFunc;

    public function __construct(callable $filterFunc)
    {
        $this->filterFunc = $filterFunc;
    }

    public function filter(ParentInterface $parent)
    {
        $result = [];

        foreach ($parent->getChildren() as $child) {
            if (call_user_func($this->filterFunc, $child)) {
                $result[] = $child;
            }

            if ($child instanceof ParentInterface) {
                $result = array_merge($result, $this->filter($child));
            }
        }

        return $result;
    }
}
