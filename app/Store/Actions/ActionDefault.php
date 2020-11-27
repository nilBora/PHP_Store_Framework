<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\Proxy\ProxyInterface;
use NilBora\NSF\Store\Request\StoreRequestInterface;
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
    protected $options;
    
    public function __construct(StoreModel $model, ProxyInterface $proxy, Event $event, StoreRequestInterface $request, array $options = [])
    {
        $this->model = $model;
        $this->event = $event;
        $this->request = $request;
        $this->proxy = $proxy;
        $this->options = $options;
        
        if (array_key_exists('ID', $options)) {
            $this->primaryKeyValue = $options['ID'];
        }
    }
    
    protected function getPreparedValues(array $values)
    {
        foreach ($values as $itemKey => $item) {
            $item->CHECK_SUM = md5(json_encode($item));
        }
        
        return $values;
    } // end getPreparedValues
}
