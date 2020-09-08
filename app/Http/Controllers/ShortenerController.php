<?php
namespace App\Http\Controllers;

use NilBora\NSF\Events\EventData;

class ShortenerController extends Controller
{
    public function onBeforeInsert(EventData $eventData)
    {
        $values = $eventData->getValues();
        $values['code'] = "x".mt_rand(1, 10000);
        $values['cdate'] = date("Y-m-d H:i:s");
        $eventData->saveValues($values);
    }
    
    public function onBeforeList(EventData $eventData)
    {
        // TODO: Logic Before List
    }
}
