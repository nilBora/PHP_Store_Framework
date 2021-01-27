<?php

namespace Jtrw\StoreView\Fields;

class TextareaField extends AbstractField implements FieldInterface
{
    public function fetchByEdit()
    {
        return view('form.fields.edit.textarea', ['options' => $this->options]);
    }
}
