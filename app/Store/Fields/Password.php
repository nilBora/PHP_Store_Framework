<?php

namespace Jtrw\Store\Fields;

class Password extends AbstractFieldType
{
    public function getValue(): string
    {
        $value = parent::getValue();
        return strlen($value) !== 32 ? md5($value) : $value;
    } // end getValue
}
