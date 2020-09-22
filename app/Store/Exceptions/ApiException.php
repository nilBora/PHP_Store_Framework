<?php
namespace NilBora\NSF\Store\Exceptions;
class ApiException extends \Exception
{
    public function __construct($message = '', $code = 400)
    {
        parent::__construct($message, $code);
    }
}
