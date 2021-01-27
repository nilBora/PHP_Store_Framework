<?php
namespace Jtrw\Store;

use Jtrw\Events\EventManagerInterface;
use Jtrw\Store\Actions\ActionInterface;
use Jtrw\Store\Exceptions\ActionNotFountException;
use Jtrw\Store\Proxy\ProxyInterface;
use Jtrw\Store\Request\StoreRequestInterface;

class Store implements StoreInterface
{
    const FIELD_CHECK_SUM = "CHECK_SUM";

    const HOOK_BEFORE_LIST = "BeforeList";
    const HOOK_AFTER_LIST  = "AfterList";

    protected $proxy;
    protected $tableName;
    protected $options;
    protected $model;
    protected $event;
    protected $request;

    public function __construct(string $tableName, StoreRequestInterface $request, ProxyInterface $proxy, EventManagerInterface $event, array $options = [])
    {
        $this->proxy = $proxy;
        $this->tableName = $tableName;
        $this->options = $options;
        $this->model = new StoreModel($this);
        $this->event = $event;
        $this->request = $request;
    }

    public function createActionInstance(string $actionName, array $options = []): ActionInterface
    {
        $this->model->load();
        $actionName = "\Jtrw\Store\Actions\Action".ucfirst(strtolower($actionName));

        if (!class_exists($actionName)) {
            throw new ActionNotFountException();
        }

        return new $actionName($this->model, $this->proxy, $this->event, $this->request, $options);
    } // end createActionInstance

    public function actionStart(string $actionName, array $options = []): StoreResponseInterface
    {
        $actionInstance = $this->createActionInstance($actionName, $options);

        return $actionInstance->onStart();
    } // end actionStart

    public function getOptions(): array
    {
        return $this->options;
    } // end getOptions

    public function getTableName(): string
    {
        return $this->tableName;
    } // end getTableName

    public function addListener(string $name, array $data)
    {
        $this->event->addListener($name, $data);
    } // end addListener

    public function getProxy(): ProxyInterface
    {
        return $this->proxy;
    } // end getProxy

    public function getModel(): StoreModelInterface
    {
        return $this->model;
    } // end getModel
}
