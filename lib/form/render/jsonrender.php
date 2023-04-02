<?php

namespace Bx\Options\Form\Render;

use Bx\Options\Form\Interfaces\AttributeInterface;
use Bx\Options\Form\Interfaces\FormElementInterface;
use Bx\Options\Form\Interfaces\HasAttribute;
use Bx\Options\Form\Interfaces\HasAttributeInterface;
use Bx\Options\Form\Interfaces\ParentInterface;
use Bx\Options\Form\Interfaces\UiElementInterface;

class JsonRender implements RenderInterface
{
    public function getContent(UiElementInterface $element): string
    {
        return json_encode($this->getContentArray($element), JSON_UNESCAPED_UNICODE);
    }

    public function getContentArray(UiElementInterface $element): array
    {
        return $this->getElementDataData($element->getElementName(), $element);
    }

    private function getElementDataData(string $type, UiElementInterface $element): array
    {
        $elementData = ['type' => $type, 'properties' => $this->getAttributeDataList($element)];
        $childrenList = $this->getChildrenList($element);
        if (!empty($childrenList)) {
            $elementData['children'] = $childrenList;
        }
        if($element instanceof FormElementInterface) {
            $this->writeFormElementData($element, $elementData);
        }

        return $elementData;
    }

    private function writeFormElementData(FormElementInterface $element, array &$elementData): void
    {
        $elementData['name'] = $element->getName();
        $elementData['label'] = $element->getLabel();
        $elementData['value'] = $element->getValue();
    }

    private function getAttributeDataList(UiElementInterface $element): array
    {
        if (!($element instanceof HasAttributeInterface)) {
            return [];
        }

        $attributeDataList = [];
        foreach ($element->getAttributes() as $attribute) {
            /** @var $attribute AttributeInterface */
            $attributeDataList[$attribute->getKey()] = $attribute->getValue();
        }

        return $attributeDataList;
    }

    private function getChildrenList(UiElementInterface $element): array
    {
        if (!($element instanceof ParentInterface)) {
            return [];
        }

        $childrenList = [];
        foreach ($element->getChildren() as $childElement) {
            $elementType = $childElement->getElementName();
            $childrenList[] = $this->getElementDataData($elementType, $childElement);
        }
        return $childrenList;
    }


}