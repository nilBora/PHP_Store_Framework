<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\Proxy\ProxyInterface;
use NilBora\NSF\Store\Request\StoreRequestInterface;
use NilBora\NSF\Store\StoreModel;
use NilBora\NSF\Events\Event;
use NilBora\NSF\Store\StoreResponse;

class ActionRemove extends ActionDefault implements ActionInterface
{
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
    
        $isRemove = $this->proxy->remove($tableName, $search);
        $options = [
            'isCustom' => true
        ];
        return new StoreResponse(['remove' => $isRemove], $this->model, $options);
    }
}
