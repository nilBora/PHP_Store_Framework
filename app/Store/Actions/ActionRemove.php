<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\Request\IStoreRequest;
use NilBora\NSF\Store\StoreModel;
use NilBora\NSF\Events\Event;
use NilBora\NSF\Store\StoreResponse;

class ActionRemove extends ActionDefault implements IAction
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
        
        $search = [
            [
                $this->primaryKey,
                '=',
                $this->primaryKeyValue
            ]
        ];
    
        $isRemove = $this->model->getStore()->remove($tableName, $search);
        $options = [
            'isCustom' => true
        ];
        return new StoreResponse(['remove' => $isRemove], $this->model, $options);
    }
}
