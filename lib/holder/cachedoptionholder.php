<?php

namespace Bx\Options\Holder;

use Bitrix\Main\Result;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class CachedOptionHolder implements OptionHolderInterface
{
    private OptionHolderInterface $optionHolder;
    private CacheInterface $cache;
    private int $ttl;

    public function __construct(OptionHolderInterface $optionHolder, CacheInterface $cache, int $ttl = 3600)
    {
        $this->optionHolder = $optionHolder;
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    /**
     * @param string $key
     * @param string|null $keySpace
     * @param mixed $defaultValue
     * @return mixed
     * @throws InvalidArgumentException
     * @psalm-suppress InvalidThrow
     */
    public function getOptionValue(string $key, ?string $keySpace = null, $defaultValue = null)
    {
        $keySpace = $keySpace ?? $this->getDefaultKeySpace();
        $cacheKey = "$keySpace.$key";
        $result = $this->cache->get($cacheKey);
        if ($result !== null) {
            return $result;
        }

        $result = $this->optionHolder->getOptionValue($key, $keySpace, $defaultValue);
        if ($result !== null) {
            $this->cache->set($cacheKey, $result, $this->ttl);
        }

        return $result;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string|null $keySpace
     * @return Result
     * @throws InvalidArgumentException
     * @psalm-suppress InvalidThrow
     */
    public function setOptionValue(string $key, $value, ?string $keySpace = null): Result
    {
        $keySpace = $keySpace ?? $this->getDefaultKeySpace();
        $resulSetValue = $this->optionHolder->setOptionValue($key, $value, $keySpace);
        if (!$resulSetValue->isSuccess()) {
            return $resulSetValue;
        }

        $cacheKey = "$keySpace.$key";
        $this->cache->set($cacheKey, $value, $this->ttl);
        return $resulSetValue;
    }

    public function getDefaultKeySpace(): string
    {
        return $this->optionHolder->getDefaultKeySpace();
    }
}
