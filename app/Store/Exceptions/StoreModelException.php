<?php
namespace NilBora\NSF\Store\Exceptions;

class StoreModelException extends \Exception
{
    public function __construct($message = '', $code = 500)
    {
        parent::__construct($message, $code);
    }
}
