<?php
namespace Jtrw\Store\Actions;

use Jtrw\Store\StoreResponseInterface;
use Jtrw\Store\StoreResponse;

class ActionRemove extends ActionDefault implements ActionInterface
{
    public function onStart(): StoreResponseInterface
    {
        $tableName = $this->model->getTableName();

        $search = [
            [
                $this->primaryKey,
                '=',
                $this->primaryKeyValue
            ]
        ];

        $isRemove = $this->proxy->remove($tableName, $search);

        $options = [
            'isCustom' => true
        ];
        return new StoreResponse($this->model, ['remove' => $isRemove], $options);
    }
}
