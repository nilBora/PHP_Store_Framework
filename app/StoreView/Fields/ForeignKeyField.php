<?php

namespace Jtrw\StoreView\Fields;

class ForeignKeyField extends AbstractField implements FieldInterface
{
    public function fetchByList()
    {
        $value = $this->getValue();
        
        $search = [
            $this->options['foreignKeyField'] => $value
        ];
    
        $row = $this->proxy->loadRow($this->options['foreignTable'], $search);

        return $row->{$this->options['foreignValueField']};
        
    }
    public function fetchByEdit()
    {
        $rows = $this->proxy->load($this->options['foreignTable']);
       
        return view('form.fields.foreignKey', ['options' => $this->options, 'selectRows' => $rows]);
    }
}
