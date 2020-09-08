<?php
namespace NilBora\NSF\Events;

class Event
{
    protected $hooks;
    protected $listeners = [];
    
    public function __construct()
    {
    }
    
    public function fireHook($hookName, &$target)
    {
        foreach ($this->listeners as $name => $listener) {
            if ($listener['name'] != $hookName) {
                continue;
            }
    
            $target["event"] = $this;
            
            $eventData = new EventData($target);
            $pluginNamespace = $listener['plugin'];
            $useClass = new $pluginNamespace();
            call_user_func_array([$useClass, $listener['method']], [$eventData]);
        }
        //$this->hooks[$hookName] = $values;
    }
    
    public function addListener($name, $data)
    {
        $this->listeners[$name] = $data;
    }
}
