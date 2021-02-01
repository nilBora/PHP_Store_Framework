<?php
namespace Jtrw\Store;

use Jtrw\Events\EventManagerInterface;
use Jtrw\Store\Actions\ActionInterface;
use Jtrw\Store\Exceptions\ActionNotFountException;
use Jtrw\Store\Proxy\ProxyInterface;
use Jtrw\Store\Request\StoreRequestInterface;
use Symfony\Component\HttpFoundation\Request;

class Store implements StoreInterface
{
    const FIELD_CHECK_SUM = "CHECK_SUM";

    const HOOK_BEFORE_LIST = "BeforeList";
    const HOOK_AFTER_LIST  = "AfterList";

    protected ProxyInterface $proxy;
    protected string $tableName;
    protected array $options;
    protected StoreModelInterface $model;
    protected EventManagerInterface $event;
    protected Request $request;

    public function __construct(string $tableName, ProxyInterface $proxy, EventManagerInterface $event, array $options = [])
    {
        $this->proxy = $proxy;
        $this->tableName = $tableName;
        $this->options = $options;
        $this->model = new StoreModel($this);
        $this->event = $event;
    }

    public function createActionInstance(string $actionName, Request $request = null, array $options = []): ActionInterface
    {
        $this->model->load();
        $actionName = "\Jtrw\Store\Actions\Action".ucfirst(strtolower($actionName));

        if (!class_exists($actionName)) {
            throw new ActionNotFountException();
        }

        return new $actionName($this->model, $this->proxy, $this->event, $request, $options);
    } // end createActionInstance

    public function actionStart(string $actionName, Request $request = null, array $options = []): StoreResponseInterface
    {
        if (!$request) {
            $request = new Request();
        }
        $actionInstance = $this->createActionInstance($actionName, $request, $options);

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
