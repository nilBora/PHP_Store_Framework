<?php

namespace Jtrw\Store\Fields;

abstract class AbstractFieldType implements FieldTypeInterface
{
    protected array $field;

    public function __construct(array $filed)
    {
        $this->field = $filed;
    } // __construct

    public function getName(): string
    {
        return $this->field['name'];
    } // getName

    public function getValue()
    {
        return $this->field['value'];
    } // end getValue
}
