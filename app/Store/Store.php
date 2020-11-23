<?php
namespace NilBora\NSF\Store;

use NilBora\NSF\Events\Event;
use NilBora\NSF\Store\Actions\ActionList;
use NilBora\NSF\Store\Actions\ActionInfo;
use NilBora\NSF\Store\Actions\ActionInsert;
use NilBora\NSF\Store\Actions\ActionEdit;
use NilBora\NSF\Store\Actions\ActionRemove;
use NilBora\NSF\Store\Proxy\IProxy;
use NilBora\NSF\Store\Request\IStoreRequest;

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
    
    public function __construct(string $tableName, IStoreRequest $request, IProxy $proxy, Event $event, array $options = [])
    {
        $this->proxy = $proxy;
        $this->tableName = $tableName;
        $this->options = $options;
        $this->model = new StoreModel($this);
        $this->event = $event;
        $this->request = $request;
    }
    
    public function createActionList()
    {
        $this->model->load();
        
        $actionInstance = new ActionList($this->model, $this->proxy, $this->event, $this->request);
        
        return $actionInstance->onStart();
    }
    
    public function createActionInfo(int $idRow)
    {
        $this->model->load();

        $actionInstance = new ActionInfo($this->model, $this->proxy, $this->event, $this->request, $idRow);
    
        return $actionInstance->onStart();
    }
    
    public function createActionInsert()
    {
        $this->model->load();
    
        $actionInstance = new ActionInsert($this->model, $this->proxy, $this->event, $this->request);
        
        return $actionInstance->onStart();
    }
    
    public function createActionEdit(int $idRow)
    {
        $this->model->load();

        $actionInstance = new ActionEdit($this->model, $this->proxy, $this->event, $this->request, $idRow);

        return $actionInstance->onStart();
    }
    
    public function createActionRemove($idRow)
    {
        $this->model->load();
    
        $actionInstance = new ActionRemove($this->model, $this->proxy, $this->event, $this->request, $idRow);
    
        return $actionInstance->onStart();
    }
    
    public function getOptions()
    {
        return $this->options;
    }
    
    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function addListener($name, $data)
    {
        $this->event->addListener($name, $data);
    }
    
    public function getProxy()
    {
        return $this->proxy;
    } // end getProxy
}
