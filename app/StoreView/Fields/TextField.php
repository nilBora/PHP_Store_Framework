<?php

namespace Jtrw\StoreView\Fields;

class TextField extends AbstractField implements FieldInterface
{
    public function fetchList()
    {
    
    }
    
    public function fetchByEdit()
    {
        return view('form.fields.text', ['options' => $this->options]);
    }
}
