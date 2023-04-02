<?php

namespace Bx\Options\Exception;

class InstanceExistException extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "An instance can only be initialized once";
        parent::__construct($message, $code, $previous);
    }
}
