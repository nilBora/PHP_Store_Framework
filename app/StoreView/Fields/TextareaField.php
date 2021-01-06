<?php

namespace Jtrw\StoreView\Fields;

class TextareaField extends AbstractField implements FieldInterface
{
    public function fetchList()
    {
    
    }
    
    public function fetchByEdit()
    {
        return view('form.fields.textarea', ['options' => $this->options]);
    }
}
