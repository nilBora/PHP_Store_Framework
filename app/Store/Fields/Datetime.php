<?php

namespace Jtrw\Store\Fields;

class Datetime extends AbstractFieldType
{
    public function getValue()
    {
        $value = parent::getValue();

        return strtotime($value);
    } // end getValue
}
