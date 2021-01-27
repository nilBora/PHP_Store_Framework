<?php

namespace Jtrw\StoreView\Fields;

class TextField extends AbstractField implements FieldInterface
{
    public function fetchByEdit()
    {
        return view('form.fields.edit.text', ['options' => $this->options]);
    }
}
