<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\StoreResponse;

class ActionInsert extends ActionDefault implements IAction
{
    public function onStart()
    {
        $tableName = $this->model->getTableName();
        $fields = $this->model->getFields();
    
        $select = [];
        
        foreach ($fields as $field) {
            $select[] = $field['name'];
        }
        $values = [];
        $data = $this->request->all();
        
        foreach ($select as $row) {
            $values[$row] = $data[$row] ?? null;
        }
        $target = [
            'model'  => $this->model,
            'store'  => $this->model->getStore(),
            'values' => &$values
        ];

        $this->event->fireHook("BeforeInsert", $target);

        $id = $this->model->getStore()->add($tableName, $values);
        $options = [
            'isCustom' => true
        ];
        return new StoreResponse(['ID'=> $id], $this->model, $options);
    }
}
