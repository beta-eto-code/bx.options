<?php

namespace Bx\Options\Holder;

use Bitrix\Main\Result;

class ArrayOptionHolder implements OptionHolderInterface
{
    private array $options;
    private string $defaultKeySpace;

    public function __construct(string $defaultKeySpace = 'main')
    {
        $this->options = [];
        $this->defaultKeySpace = $defaultKeySpace;
    }

    public function getOptionValue(string $key, ?string $keySpace = null, $defaultValue = null)
    {
        $keySpace = $keySpace ?? $this->defaultKeySpace;
        return $this->options[$keySpace][$key] ?? $defaultValue;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string|null $keySpace
     * @return Result
     */
    public function setOptionValue(string $key, $value, ?string $keySpace = null): Result
    {
        $keySpace = $keySpace ?? $this->defaultKeySpace;
        $this->options[$keySpace][$key] = $value;
        return new Result();
    }

    public function getDefaultKeySpace(): string
    {
        return $this->defaultKeySpace;
    }
}
