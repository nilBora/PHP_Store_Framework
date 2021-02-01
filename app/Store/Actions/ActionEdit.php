<?php
namespace Jtrw\Store\Actions;

use Jtrw\Store\Exceptions\ApiException;
use Jtrw\Store\StoreModelInterface;
use Jtrw\Store\StoreResponseInterface;
use Jtrw\Store\StoreResponse;

class ActionEdit extends ActionDefault implements ActionInterface
{
    protected StoreModelInterface $model;

    public function onStart(): StoreResponseInterface
    {
        $fields = $this->model->getFields();

        $select = [];

        foreach ($fields as $field) {
            $select[] = $field['name'];
        }

        $data = $this->request->request->all();
        $files = $this->request->files->all();

        $data['FILES'] = $files;

        $fieldsFactory = $this->model->getFieldsFactory($data);
        $values = $fieldsFactory->getValues();

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

            $currentRow = $customModel->onRow($search);

            $hash = md5(json_encode($currentRow));

            if (!empty($data['CHECK_SUM']) && $hash != $data['CHECK_SUM']) {
                throw new ApiException("Data already changed!");
            }

            $items = $customModel->onUpdate($values, $search);
            return new StoreResponse($this->model, $items);
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

        return new StoreResponse($this->model, $item);
    }
}
