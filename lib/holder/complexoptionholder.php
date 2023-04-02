<?php

namespace Bx\Options\Holder;

use Bitrix\Main\Result;

class ComplexOptionHolder implements OptionHolderInterface
{
    private OptionHolderInterface $defaultOptionHolder;
    private string $defaultKeySpace;
    /**
     * @var array<array-key, callable(string $key, string $keySpace): ?OptionHolderInterface>
     */
    private array $getterHolderList;

    public function __construct(OptionHolderInterface $defaultOptionHolder, string $defaultKeySpace)
    {
        $this->defaultOptionHolder = $defaultOptionHolder;
        $this->defaultKeySpace = $defaultKeySpace;
        $this->getterHolderList = [];
    }

    /**
     * @param OptionHolderInterface $optionHolder
     * @param string $holderKeySpace
     * @param string ...$keys
     * @return void
     */
    public function addHolderOption(OptionHolderInterface $optionHolder, string $holderKeySpace, string ...$keys)
    {
        $this->setCallbackHolder(function (
            string $key,
            string $keySpace
        ) use (
            $optionHolder,
            $holderKeySpace,
            $keys
        ): ?OptionHolderInterface {
            if ($keySpace !== $holderKeySpace) {
                return null;
            }

            if (!empty($keys) && !in_array($key, $keys)) {
                return null;
            }

            return $optionHolder;
        });
    }

    /**
     * @param callable(string $key, string $keySpace): ?OptionHolderInterface $fnGetHolder
     * @return void
     */
    public function setCallbackHolder(callable $fnGetHolder)
    {
        $this->getterHolderList[] = $fnGetHolder;
    }

    /**
     * @param string $key
     * @param string|null $keySpace
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getOptionValue(string $key, ?string $keySpace = null, $defaultValue = null)
    {
        $optionHolder = $this->getOptionHolder($key, $keySpace);
        return $optionHolder->getOptionValue($key, $keySpace, $defaultValue);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string|null $keySpace
     * @return Result
     */
    public function setOptionValue(string $key, $value, ?string $keySpace = null): Result
    {
        $optionHolder = $this->getOptionHolder($key, $keySpace);
        return $optionHolder->setOptionValue($key, $value, $keySpace);
    }

    private function getOptionHolder(string $key, ?string $keySpace = null): OptionHolderInterface
    {
        $localKeySpace = $keySpace ?: $this->defaultKeySpace;
        $optionHolder = $this->defaultOptionHolder;
        foreach ($this->getterHolderList as $fnGetterHolder) {
            $getterResult = $fnGetterHolder($key, $localKeySpace);
            if ($getterResult instanceof OptionHolderInterface) {
                $optionHolder = $getterResult;
            }
        }

        return $optionHolder;
    }

    public function getDefaultKeySpace(): string
    {
        return $this->defaultKeySpace;
    }
}
