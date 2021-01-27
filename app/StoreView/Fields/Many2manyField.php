<?php

namespace Jtrw\StoreView\Fields;

class Many2manyField extends AbstractField implements FieldInterface
{
    public function fetchByList()
    {
        $value = $this->getValue();

        $names = [];
        foreach ($value as $value) {
            $names[] = $value[$this->options['foreignValueField']];
        }

        return view('form.fields.list.many2many', ['values' => $names]);
//        $search = [
//            $this->options['foreignKeyField'] => $value
//        ];
//
//        $row = $this->proxy->loadRow($this->options['foreignTable'], $search);
//
//        return $row->{$this->options['foreignValueField']};

    }
    public function fetchByEdit()
    {
        $rows = $this->proxy->load($this->options['foreignTable']);
        $values = [];
        if (is_array($this->options['value'])) {
            foreach ($this->options['value'] as $value) {
                $values[] = $value[$this->options['foreignKeyField']];
            }
        }

        return view('form.fields.edit.many2many', ['options' => $this->options, 'selectRows' => $rows, 'values' => $values]);
    }
}
