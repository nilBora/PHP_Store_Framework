<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\Proxy\IProxy;
use NilBora\NSF\Store\Request\IStoreRequest;
use NilBora\NSF\Store\StoreModel;
use NilBora\NSF\Events\Event;

abstract class ActionDefault
{
    protected $model;
    protected $primaryKey = 'id';
    protected $primaryKeyValue;
    protected $event;
    protected $request;
    protected $proxy;
    
    public function __construct(StoreModel $model, IProxy $proxy, Event $event,IStoreRequest $request)
    {
        $this->model = $model;
        $this->event = $event;
        $this->request = $request;
        $this->proxy = $proxy;
    }
    
    protected function getPreparedValues(array $values)
    {
        foreach ($values as $itemKey => $item) {
            $item->CHECK_SUM = md5(json_encode($item));
        }
        
        return $values;
    } // end getPreparedValues
}
