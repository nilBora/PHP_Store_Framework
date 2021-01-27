<?php

namespace Jtrw\StoreView\Fields;

class HiddenField extends AbstractField implements FieldInterface
{
    public function fetchByEdit()
    {
        return view('form.fields.edit.hidden', ['options' => $this->options]);
    }
}
