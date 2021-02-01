<?php
namespace Jtrw\Store\Actions;

use Jtrw\Store\StoreResponseInterface;
use Jtrw\Store\StoreResponse;
use Jtrw\Store\Store;


class ActionList extends ActionDefault implements ActionInterface
{
    public function onStart(): StoreResponseInterface
    {
        if ($this->model->hasModelFile()) {
            //XXX: New Store Logic
            return $this->onCustomModelStart();
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
            'search' => &$select
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

        return new StoreResponse($this->model, $items);
    } // end onStart

    protected function onCustomModelStart(): StoreResponseInterface
    {
        $search = [];
        $customModel = $this->model->getCustomModel();

        $request =$this->request->query->all();

        if (!empty($request['search'])) {
            $search = $request['search'];
        }

        $target = [
            'model'  => $this->model,
            'store'  => $this->model->getStore(),
            'search' => &$search
        ];

        $this->event->fireHook(Store::HOOK_BEFORE_LIST, $target);

        $items = $customModel->onList($search);

        $target['items'] = $items;

        $this->event->fireHook(Store::HOOK_AFTER_LIST, $target);

        return new StoreResponse($this->model, $items);
    } // end onCustomModelStart

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
