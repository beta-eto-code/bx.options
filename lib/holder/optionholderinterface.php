<?php

namespace Bx\Options\Holder;

use Bitrix\Main\Result;

interface OptionHolderInterface
{
    public function getDefaultKeySpace(): string;

    /**
     * @param string $key
     * @param string|null $keySpace
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getOptionValue(string $key, ?string $keySpace = null, $defaultValue = null);

    /**
     * @param string $key
     * @param mixed $value
     * @param string|null $keySpace
     * @return mixed
     */
    public function setOptionValue(string $key, $value, ?string $keySpace = null): Result;
}
