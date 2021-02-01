<?php
namespace Jtrw\StoreUtils;

use Illuminate\Http\Request;
use Jtrw\Events\EventManager;
use Jtrw\Store\Proxy\LaravelProxy;
use Jtrw\Store\Request\LaravelRequest;
use Jtrw\Store\Store;

trait StoreCreateTrait
{
    protected array $storeOptions;
    protected array $listeners = [];

    public function setStoreOptions(array $options)
    {
        $this->storeOptions = $options;
    } // end setStoreOptions

    public function addListener(string $name, array $param)
    {
        $this->listeners[$name] = $param;
    } // end addListener

    public function createStore(string $name)
    {
        $eventDispatcher = $this->_createEventDispatcher();

        return new Store($name , new LaravelProxy(), $eventDispatcher, $this->storeOptions);
    } // end createStore

    private function _createEventDispatcher(): EventManager
    {
        $eventDispatcher = new EventManager();

        if (!$this->listeners) {
            return $eventDispatcher;
        }

        foreach ($this->listeners as $name => $listener) {
           // $eventDispatcher->addListener(Store::HOOK_BEFORE_LIST, [new ShortenerController(), 'onBeforeList']);
            $eventDispatcher->addListener($name, $listener);
        }

        return $eventDispatcher;
    } // end createEventDispatcher
}
