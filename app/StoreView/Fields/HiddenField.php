<?php

namespace Jtrw\StoreView\Fields;

class HiddenField extends AbstractField implements FieldInterface
{
    public function fetchList()
    {
    
    }
    
    public function fetchByEdit()
    {
        return view('form.fields.hidden', ['options' => $this->options]);
    }
}
