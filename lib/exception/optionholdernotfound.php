<?php

namespace Bx\Options\Exception;

class OptionHolderNotFound extends \Exception
{

    public function __construct($holderClass = "", $code = 404, Throwable $previous = null)
    {
        $message = sprintf("OptionHolder %s not found, are you sure it was added? ", $holderClass);
        parent::__construct($message, $code, $previous);
    }
}
