<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\SoreResponseInterface;
use NilBora\NSF\Store\StoreResponse;

class ActionRemove extends ActionDefault implements ActionInterface
{
    public function onStart(): SoreResponseInterface
    {
        $tableName = $this->model->getTableName();
        
        $search = [
            [
                $this->primaryKey,
                '=',
                $this->primaryKeyValue
            ]
        ];
    
        $isRemove = $this->proxy->remove($tableName, $search);

        $options = [
            'isCustom' => true
        ];
        return new StoreResponse($this->model, ['remove' => $isRemove], $options);
    }
}
