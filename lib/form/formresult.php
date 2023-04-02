<?php

namespace Bx\Options\Form;

use Bx\Options\Form\Interfaces\FormElementInterface;
use Bx\Options\Form\Interfaces\ParentInterface;
use Bx\Options\Form\Interfaces\ValidatedInterface;

/**
 *
 */
class FormResult implements \Iterator
{

    /**
     * @var int
     */
    private int $index = 0;

    /**
     * @var FormElementInterface[]
     */
    private array $items;

    /**
     * @param FormElementInterface ...$formElement
     */
    public function __construct(FormElementInterface ...$formElement)
    {
        $this->items = $formElement;
    }

    /**
     * @param ParentInterface $element
     * @return FormResult
     */
    public static function initFromUiElement(ParentInterface $element): FormResult
    {
        $formResult = new self();
        foreach ($element as $item) {
            $formResult->extractChildrenFormElement($item);
        }
        return $formResult;
    }

    public function setValuesFromArray(array $array)
    {
        $this->setValues($array);
    }

    public function setValues(array $values)
    {

        foreach ($this as $element) {
            $value = $values[$element->getName()] ?? "";
            $value = is_array($value) ? serialize($value) : $value;
            $element->setValue($value);
        }
    }

    /**
     * @param ParentInterface $element
     * @return void
     */
    private function extractChildrenFormElement(ParentInterface $element)
    {
        foreach ($element as $child) {
            if ($child instanceof FormElementInterface) {
                $this->addFormElement($child);
            } elseif ($child instanceof ParentInterface) {
                $this->extractChildrenFormElement($child);
            }
        }
    }


    /**
     * @param FormElementInterface $formElement
     * @return void
     */
    public function addFormElement(FormElementInterface $formElement)
    {
        $this->items[] = $formElement;
    }

    /**
     * @param string $name
     * @return FormElementInterface|null
     */
    public function getFormElementByName(string $name): ?FormElementInterface
    {
        foreach ($this as $element) {
            if ($element->getName() === $name) {
                return $element;
            }
        }
        return null;
    }

    public function getArray(): array
    {
        $result = [];
        foreach ($this as $element) {
            $result[$element->getName()] = $element->getValue();
        }
        return $result;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->items[$this->index];
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
        return isset($this->items[$this->index]);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->index = 0;
    }

    public function validate(): ValidateResult
    {
        $result = new ValidateResult();
        foreach ($this as $element) {
            if (!$element instanceof ValidatedInterface) {
                continue;
            }
            if (!$element->validate()) {
                $result->addError($element->getName(), $element->getValidateErrorMessage());
            }
        }
        return $result;
    }
}
