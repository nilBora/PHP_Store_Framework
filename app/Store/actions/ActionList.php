<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\Exceptions\ApiException;
use NilBora\NSF\Store\Store;
use NilBora\NSF\Store\StoreResponse;

class ActionList extends ActionDefault implements IAction
{
    public function onStart()
    {
        $tableName = $this->model->getTableName();
        $fields = $this->model->getFields();
    
        $select = [];
        
        foreach ($fields as $field) {
            $select[] = $field['name'];
        }
        
        $target = [
            'model'  => $this->model,
            'store'  => $this->model->getStore(),
            'select' => &$select
        ];
    
        $this->event->fireHook(Store::HOOK_BEFORE_LIST, $target);
        
        $orderBy = [];
        $struct = $this->model->getStruct();
        
        if (!empty($struct['table']['orderBy'])) {
            $orderBy = [
                $struct['table']['orderBy']
            ];
        }
        
        $rowsPerPage = null;
        if (!empty($struct['table']['rowsForPage'])) {
            $rowsPerPage = (int) $struct['table']['rowsForPage'];
        }
        
        $items = $this->model->getStore()->buildQuery($tableName, $select, [], $orderBy, [], false, $rowsPerPage);
        
        return new StoreResponse($items, $this->model);
    } // end onStart
}
