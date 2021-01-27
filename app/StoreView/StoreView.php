<?php
namespace Jtrw\StoreView;

use Jtrw\Store\Proxy\LaravelProxy;
use Jtrw\Store\StoreResponseInterface;
use Jtrw\StoreView\Exceptions\StoreViewFieldNotFoundException;

class StoreView
{
    protected $name;
    protected $response;

    private array $_fields = [];
    private array $_items = [];
    private array $_fieldsObjects = [];

    public function __construct(string $name, StoreResponseInterface $response)
    {
        $this->name = $name;
        $this->response = $response;
    } // end __construct

    public function fetchListHeaders()
    {
        $fieldsObjects = $this->_getFieldsObjects();

        return view('table.table_headers', ['fields' => $fieldsObjects]);
    }

    public function fetchListFooter()
    {
        $fieldsObjects = $this->_getFieldsObjects();

        return view('table.table_footer_list', ['fields' => $fieldsObjects]);
    }

    public function fetchList()
    {
        $fields = $this->_getFields();

        $items = $this->_getItems();
        $fieldsObjects = $this->_getFieldsObjects();

        $itemsObjects = [];
        foreach ($items as $item) {
            $itemsObjects[] = new FieldEntity($item, $fields, new LaravelProxy());
        }

        return view(
            'table.table_list',
            [
                'itemsObjects'   => $itemsObjects,
                'fields'         => $fields,
                'items'          => $items,
                'fieldsObjects'  => $fieldsObjects,
                'storeName'      => $this->name,
                "isSearch"       => $this->_isSearch($fieldsObjects)
            ]
        );
    }

    private function _isSearch(array $fieldsObjects): bool
    {
        foreach ($fieldsObjects as $field) {
            if (!$field->isHide() && $field->hasSearch()) {
                return true;
            }
        }

        return false;
    } // end _isSearch

    private function _getFieldsObjects(): array
    {
        if ($this->_fieldsObjects) {
            return $this->_fieldsObjects;
        }

        $fields = $this->_getFields();
        $fieldsObjects = [];
        foreach ($fields as $fieldName => $field) {
            $className = '\Jtrw\StoreView\Fields\\'.ucfirst(strtolower($field['type']))."Field";
            if (!class_exists($className)) {
                throw new StoreViewFieldNotFoundException($className);
            }

            $fieldsObjects[] = new $className($field, new LaravelProxy());
        }
        $this->_fieldsObjects = $fieldsObjects;
        return $fieldsObjects;
    } // end getFieldsObjects

    private function _getFields()
    {
        if ($this->_fields !== []) {
            return $this->_fields;
        }
        $this->_fields = $this->response->getData()['data']['struct']['fields'];

        return $this->_fields;
    } // end _getFields

    private function _getItems()
    {
        if ($this->_items !== []) {
            return $this->_fields;
        }

        $this->_items = $this->response->getData()['data']['items'] ?? [];
        return $this->_items;
    } // end _getItems

}
