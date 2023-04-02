<?php

namespace Bx\Options;

use Bx\Options\Holder\BitrixOptionHolder;
use Bx\Options\Holder\ConfigurationOptionHolder;
use Bx\Options\Holder\OptionHolderInterface;
use Bx\Options\Exception\InstanceExistException;
use Bx\Options\Exception\OptionHolderNotFound;

class Manager
{

    private static $instance = null;

    private array $optionHolders = [];

    protected function __construct(OptionHolderInterface ...$optionHolders)
    {
        $this->optionHolders = $optionHolders;
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }


    public static function getInstance()
    {
        if (self::$instance instanceof Manager) {
            return self::$instance;
        }
        return self::$instance = self::build();
    }

  /**
   * @throws InstanceExistException
   */
    private static function build($defaultHandlers = [])
    {
        if (self::$instance instanceof Manager) {
            throw new InstanceExistException();
        }
        self::$instance = new static();
        $defaultHandlers = !empty($defaultHandlers) ? $defaultHandlers : self::getInstance()->getDefaultOptionHolders();
        foreach ($defaultHandlers as $holder) {
            self::$instance->addOptionHolder(get_class($holder), $holder);
        }
        return self::$instance;
    }

    private function getDefaultOptionHolders(): array
    {
        return [
            new BitrixOptionHolder(),
            new ConfigurationOptionHolder()
        ];
    }

    public function addOptionHolder(string $key, OptionHolderInterface $holder)
    {
        $this->optionHolders[$key] = $holder;
    }

    public function getOptionHolder(string $key): OptionHolderInterface
    {
        $optionHolder = $this->optionHolders[$key];
        if (!$optionHolder instanceof OptionHolderInterface) {
            throw new OptionHolderNotFound($key);
        }
        return $optionHolder;
    }

  /**
   * @throws OptionHolderNotFound
   */
    public function getOption($namespace, $key, $default = "", $holderClass = null)
    {
        if ($holderClass) {
            return $this->getOptionHolder($holderClass)->getOptionValue($key, $namespace, $default);
        }
        $value = "";
        foreach ($this->optionHolders as $optionHolder) {
            $value = $optionHolder->getOptionValue($key, $namespace, $default);
            if ($value) {
                break;
            }
        }
        return $value ?: $default;
    }

    public function setOption($namespace, $key, $value, ?OptionHolderInterface $holder = null)
    {
        if ($holder) {
            return $holder->setOptionValue($key, $value, $namespace);
        }
        foreach ($this->optionHolders as $optionHolder) {
            $result = $optionHolder->setOptionValue($key, $value, $namespace);
            if ($result->isSuccess()) {
                break;
            }
        }
    }
}
