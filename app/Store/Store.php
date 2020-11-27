<?php
namespace NilBora\NSF\Store;

use NilBora\NSF\Events\Event;
use NilBora\NSF\Store\Actions\ActionList;
use NilBora\NSF\Store\Actions\ActionInfo;
use NilBora\NSF\Store\Actions\ActionInsert;
use NilBora\NSF\Store\Actions\ActionEdit;
use NilBora\NSF\Store\Actions\ActionRemove;
use NilBora\NSF\Store\Exceptions\ActionNotFountException;
use NilBora\NSF\Store\Proxy\ProxyInterface;
use NilBora\NSF\Store\Request\StoreRequestInterface;

class Store
{
    const FIELD_CHECK_SUM = "CHECK_SUM";
    
    const HOOK_BEFORE_LIST = "BeforeList";
    
    protected $proxy;
    protected $tableName;
    protected $options;
    protected $model;
    protected $event;
    protected $request;
    
    public function __construct(string $tableName, StoreRequestInterface $request, ProxyInterface $proxy, Event $event, array $options = [])
    {
        $this->proxy = $proxy;
        $this->tableName = $tableName;
        $this->options = $options;
        $this->model = new StoreModel($this);
        $this->event = $event;
        $this->request = $request;
    }
    
    public function createActionInstance(string $actionName, array $options = [])
    {
        $this->model->load();
        $actionName = "\NilBora\NSF\Store\Actions\Action".ucfirst(strtolower($actionName));

        if (!class_exists($actionName)) {
            throw new ActionNotFountException();
        }
        
        return new $actionName($this->model, $this->proxy, $this->event, $this->request, $options);
    } // end createActionInstance
    
    public function actionStart(string $actionName, array $options = [])
    {
        $actionInstance = $this->createActionInstance($actionName, $options);
        
        return $actionInstance->onStart();
    } // end actionStart
    
    public function getOptions()
    {
        return $this->options;
    } // end getOptions
    
    public function getTableName()
    {
        return $this->tableName;
    } // end getTableName
    
    public function addListener($name, $data)
    {
        $this->event->addListener($name, $data);
    } // end addListener
    
    public function getProxy()
    {
        return $this->proxy;
    } // end getProxy
}
