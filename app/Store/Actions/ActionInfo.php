<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\Proxy\ProxyInterface;
use NilBora\NSF\Store\Request\StoreRequestInterface;
use NilBora\NSF\Store\StoreModel;
use NilBora\NSF\Events\Event;
use NilBora\NSF\Store\StoreResponse;

class ActionInfo extends ActionDefault implements ActionInterface
{
    public function onStart(): StoreRequestInterface
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
            return new StoreResponse($items, $this->model);
        }
        
        $tableName = $this->model->getTableName();
        $fields = $this->model->getFields();
        
        $select = [];

        foreach ($fields as $field) {
            $select[] = $field['name'];
        }
    
        

        $items = $this->proxy->build($tableName, $select, $search, [], [], true);

        return new StoreResponse($items, $this->model);
    }
}
