<?php

namespace Bx\Options\Holder;

use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Bitrix\Main\Config\Configuration;
use Throwable;

class ConfigurationOptionHolder implements OptionHolderInterface
{
    private string $mainSettingsKeySpace;

    public function __construct(string $mainSettingsKeySpace = 'settings')
    {
        $this->mainSettingsKeySpace = $mainSettingsKeySpace;
    }

    public function getOptionValue(string $key, ?string $keySpace = null, $defaultValue = null)
    {
        if ($keySpace === $this->mainSettingsKeySpace) {
            $keySpace = null;
        }
        return Configuration::getInstance($keySpace)->get($key) ?? $defaultValue;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string|null $keySpace
     * @return Result
     */
    public function setOptionValue(string $key, $value, ?string $keySpace = null): Result
    {
        if ($keySpace === $this->mainSettingsKeySpace) {
            $keySpace = null;
        }
        $result = new Result();
        try {
            Configuration::getInstance($keySpace)->add($key, $value);
        } catch (Throwable $exception) {
            return $result->addError(new Error($exception->getMessage()));
        }

        return $result;
    }

    public function getDefaultKeySpace(): string
    {
        return $this->mainSettingsKeySpace;
    }
}
