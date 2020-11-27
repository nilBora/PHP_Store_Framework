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
    
    public function onStart()
    {
        $tableName = $this->model->getTableName();
        $fields = $this->model->getFields();
    
        $select = [];

        foreach ($fields as $field) {
            $select[] = $field['name'];
        }
        $values = [];
        $data = $this->request->all();
        
        foreach ($select as $row) {
            $values[$row] = $data[$row] ?? null;
        }
        
        $search = [
            [
                $this->primaryKey,
                '=',
                $this->primaryKeyValue
            ]
        ];
        
    
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
