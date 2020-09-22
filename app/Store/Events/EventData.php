<?php
namespace NilBora\NSF\Events;

use NilBora\NSF\Events\Exceptions\EventException;

class EventData
{
    protected $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    } // end __construct
    
    public function getValues()
    {
        if (array_key_exists("values", $this->data)) {
            return $this->data["values"];
        }
        
        throw new EventException("Values Not Found in Data");
    } // end getValues
    
    public function saveValues($values)
    {
        $this->data["values"] = $values;
    } // end saveValues
    
    public function getData()
    {
        return $this->data;
    } // end getData
}