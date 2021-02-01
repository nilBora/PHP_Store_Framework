<?php
namespace Jtrw\StoreView\Fields;

class FileField extends AbstractField implements FieldInterface
{
    public function fetchByEdit()
    {
        return view('form.fields.edit.file', ['field' => $this]);
    }
}
