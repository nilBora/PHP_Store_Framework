<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\SoreResponseInterface;
use NilBora\NSF\Store\StoreResponse;

class ActionInfo extends ActionDefault implements ActionInterface
{
    public function onStart(): SoreResponseInterface
    {
        $search = [
            [
                $this->primaryKey,
                '=',
                $this->primaryKeyValue
            ]
        ];
        
        if ($this->model->hasModelFile()) {
            //XXX: New Store Logic
            $customModel = $this->model->getCustomModel();
            $items = $customModel->onRow($search);

            return new StoreResponse($this->model, $items);
        }
        
        $tableName = $this->model->getTableName();
        $fields = $this->model->getFields();
        
        $select = [];

        foreach ($fields as $field) {
            $select[] = $field['name'];
        }
    
        

        $items = $this->proxy->build($tableName, $select, $search, [], [], true);

        return new StoreResponse($this->model, $items);
    }
}
