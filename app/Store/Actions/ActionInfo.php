<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\Proxy\IProxy;
use NilBora\NSF\Store\Request\IStoreRequest;
use NilBora\NSF\Store\StoreModel;
use NilBora\NSF\Events\Event;
use NilBora\NSF\Store\StoreResponse;

class ActionInfo extends ActionDefault implements ActionInterface
{
    public function __construct(StoreModel $model, IProxy $proxy, Event $event, IStoreRequest $request, int $idRow)
    {
        $this->model = $model;
        $this->primaryKeyValue = $idRow;
        $this->event = $event;
        $this->request = $request;
        $this->proxy = $proxy;
    }
    
    public function onStart()
    {
        $search = [
            [
                $this->primaryKey,
                '=',
                $this->primaryKeyValue
            ]
        ];
        
        if ($this->model->hasModelFile()) {
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
