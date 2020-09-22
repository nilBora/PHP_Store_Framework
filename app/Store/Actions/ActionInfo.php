<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\Request\IStoreRequest;
use NilBora\NSF\Store\StoreModel;
use NilBora\NSF\Events\Event;
use NilBora\NSF\Store\StoreResponse;

class ActionInfo extends ActionDefault implements IAction
{
    public function __construct(StoreModel $model, Event $event, IStoreRequest $request, int $idRow)
    {
        $this->model = $model;
        $this->primaryKeyValue = $idRow;
        $this->event = $event;
        $this->request = $request;
    }
    
    public function onStart()
    {
        
        $tableName = $this->model->getTableName();
        $fields = $this->model->getFields();
        
        $select = [];
        
        foreach ($fields as $field) {
            $select[] = $field['name'];
        }
    
        $search = [
            [
                $this->primaryKey,
                '=',
                $this->primaryKeyValue
            ]
        ];

        $items = $this->model->getStore()->buildQuery($tableName, $select, $search, [], [], true);

        return new StoreResponse($items, $this->model);
    }
}
