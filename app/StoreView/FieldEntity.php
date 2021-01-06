<?php

namespace Jtrw\StoreView;

use Jtrw\Store\Proxy\ProxyInterface;
use Jtrw\StoreView\Exceptions\FieldNotFoundPropertyException;
use Jtrw\StoreView\Exceptions\StoreViewFieldNotFoundException;
use Jtrw\StoreView\Fields\FieldInterface;

class FieldEntity
{
    private array $_fieldsTypes;
    private array $_fieldData;
    
    public function __construct(array $fieldData, array $fieldsTypes, ProxyInterface $proxy = null)
    {
        $this->_fieldData = $fieldData;

        $fieldsObjects = [];
        foreach ($fieldData as $key => $value) {
            foreach ($fieldsTypes as $fieldName => $field) {
                if ($key !== $fieldName) {
                    continue;
                }
                $className = '\Jtrw\StoreView\Fields\\'.ucfirst(strtolower($field['type']))."Field";
                if (!class_exists($className)) {
                    throw new StoreViewFieldNotFoundException($className);
                }
                $field['value'] = $value;

                $fieldsObjects[$key] = new $className($field, $proxy);
            }
        }
        $this->_fieldsTypes = $fieldsObjects;
    }
    
    public function getFields(): array
    {
        return $this->_fieldsTypes;
    }
    
    public function getID(): int
    {
        if (!array_key_exists('id', $this->_fieldData)) {
            throw new StoreViewFieldNotFoundException(print_r($this->_fieldData, true));
        }
        return $this->_fieldData['id'];
    } // end getID
    
    public function getValue()
    {
        if (!array_key_exists($this->_fieldType->getName(), $this->_fieldData)) {
            throw new FieldNotFoundPropertyException($this->_fieldType->getName());
        }
        return $this->_fieldData[$this->_fieldType->getName()];
    } // end getValue
    
}
