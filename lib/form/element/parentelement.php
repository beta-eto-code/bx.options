<?php
namespace Bx\Options\Form\Element;

use Bx\Options\Form\Interfaces\ParentInterface;
use Bx\Options\Form\Interfaces\UiElementInterface;

abstract class ParentElement extends BaseElement implements ParentInterface
{
    /** @var int  */
    private int $index = 0;
    /** @var array  */
    private array $children = [];


    /**
     * @param UiElementInterface $element
     * @return $this
     */
    public function addChild(UiElementInterface $element): ParentInterface
    {
        $this->children[] = $element;
        return $this;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

     /**
      * @return mixed
      */
    public function current()
    {
        return $this->children[$this->index];
    }

     /**
      * @return void
      */
    public function next()
    {
        ++$this->index;
    }

     /**
      * @return mixed|null
      */
    public function key()
    {
        return $this->index;
    }

     /**
      * @return bool
      */
    public function valid()
    {
        return isset($this->children[$this->index]);
    }

     /**
      * @return void
      */
    public function rewind()
    {
        $this->index = 0;
    }
}
