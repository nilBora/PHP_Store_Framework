<?php
namespace NilBora\NSF\Store\Actions;

use App\Plugins\Pages\Pages;
use NilBora\NSF\Store\Exceptions\ApiException;
use NilBora\NSF\Store\Store;
use NilBora\NSF\Store\StoreResponse;


class ActionList extends ActionDefault implements ActionInterface
{
    public function onStart()
    {
        if ($this->model->hasModelFile()) {
            $customModel = $this->model->getCustomModel();
            $items = $customModel->onList();
            return new StoreResponse($items, $this->model);
        }
        $tableName = $this->model->getTableName();
        $fields = $this->model->getFields();
    
        $select = [];
        
        foreach ($fields as $field) {
            if ($field['type'] == 'foreignKey') {
                $select[] = $field['foreignTable'].".".$field['foreignValueField']." as ".$field['alias'];
                continue;
            }
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
        $queryData = [];
        
        $queryData = $this->getPreparedQueryByFields($struct['fields'], $struct['table'], $queryData);

        $join = [];
        
        $items = $this->proxy->build($tableName, $select, [], $orderBy, $join, false, $rowsPerPage, $queryData);
        
        return new StoreResponse($items, $this->model);
    } // end onStart
    
    protected function getPreparedQueryByFields(array $fields, array $table, array $queryData): array
    {
        foreach ($fields as $field) {
            $queryData = $this->getPreparedQueryByField($field, $table, $queryData);
        }
        return $queryData;
    } // end getPreparedQueryByFields
    
    protected function getPreparedQueryByField(array $field, array $table, array $queryData): array
    {
        if ($field['type'] == 'foreignKey') {
            $queryData['join'][] = [
                $field['foreignTable'],
                $table['name'].".".$field['name'],
                '=',
                $field['foreignTable'].".".$field['foreignKeyField']
            ];
        }
        return $queryData;
    } // end getPreparedQueryByField
}
