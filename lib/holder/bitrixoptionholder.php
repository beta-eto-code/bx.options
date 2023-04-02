<?php

namespace Bx\Options\Holder;

use Bitrix\Main\Result;
use Bitrix\Main\Error;
use Bitrix\Main\Config\Option;
use Throwable;

class BitrixOptionHolder implements OptionHolderInterface
{
    private string $defaultKeySpace;

    public function __construct(string $defaultKeySpace = 'main')
    {
        $this->defaultKeySpace = $defaultKeySpace;
    }

    public function getOptionValue(string $key, ?string $keySpace = null, $defaultValue = null)
    {
        $keySpace = $keySpace ?: $this->defaultKeySpace;
        return Option::get($keySpace, $key, $defaultValue);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string|null $keySpace
     * @return Result
     */
    public function setOptionValue(string $key, $value, ?string $keySpace = null): Result
    {
        $result = new Result();
        $keySpace = $keySpace ?: $this->defaultKeySpace;
        try {
            Option::set($keySpace, $key, $value);
        } catch (Throwable $exception) {
            return $result->addError(new Error($exception->getMessage()));
        }

        return $result;
    }

    public function getDefaultKeySpace(): string
    {
        return $this->defaultKeySpace;
    }
}
