<?php
namespace Jtrw\StoreView\Fields;

class PasswordField extends AbstractField implements FieldInterface
{
    public function fetchByList()
    {
        return "******";
    }

    public function fetchByEdit()
    {
        return view('form.fields.edit.password', ['options' => $this->options]);
    }
}
