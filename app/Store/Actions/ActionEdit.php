<?php
namespace NilBora\NSF\Store\Actions;

use NilBora\NSF\Store\Exceptions\ApiException;
use NilBora\NSF\Store\Proxy\ProxyInterface;
use NilBora\NSF\Store\Request\StoreRequestInterface;
use NilBora\NSF\Store\StoreModel;
use NilBora\NSF\Events\Event;
use NilBora\NSF\Store\StoreResponse;

class ActionEdit extends ActionDefault implements ActionInterface
{
    protected $model;
    
    public function onStart(): StoreRequestInterface
    {
        $fields = $this->model->getFields();
        
        $select = [];
    
        foreach ($fields as $field) {
            $select[] = $field['name'];
        }
        $values = [];
        $data = $this->request->all();
    
        foreach ($select as $row) {
            if (!isset($data[$row])) {
                continue;
            }
            $values[$row] = $data[$row];
        }
        
        $search = [
            [
                $this->primaryKey,
                '=',
                $this->primaryKeyValue
            ]
        ];
        
        
        if ($this->model->hasModelFile()) {
            //XXX: New Store Logic
            $customModel = $this->model->getCustomModel();
            $items = $customModel->onUpdate($values, $search);
            return new StoreResponse($items, $this->model);
        }
        
        $tableName = $this->model->getTableName();
    
        $currentRow = $this->proxy->build($tableName, $select, $search, [], [], true);
        if (!$currentRow) {
            throw new ApiException("Row Not Found");
        }
    

        $hash = md5(json_encode($currentRow));
        
        if (!empty($data['CHECK_SUM']) && $hash != $data['CHECK_SUM']) {
            throw new ApiException("Data already changed!");
        }
        
        $this->proxy->update($tableName, $values, $search);
    
        $item = $this->proxy->build($tableName, $select, $search, [], [], true);
    
        return new StoreResponse($item, $this->model);
    }
}
