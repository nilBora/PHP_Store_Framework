<?php

namespace Jtrw\StoreView\Fields;

class DatetimeField extends AbstractField implements FieldInterface
{
    public function fetchByEdit()
    {
        return view('form.fields.edit.datetime', ['field' => $this, 'options' => $this->options]);
    }

    public function getValue()
    {
        $value = parent::getValue();

        return date($this->getFormat(), strtotime($value));
    } // end getValue

    public function getFormat()
    {
        return $this->get('format');
    } // end getFormat
}
