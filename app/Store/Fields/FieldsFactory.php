<?php

namespace Jtrw\Store\Fields;

class FieldsFactory implements FieldsFactoryInterface
{
    private array $_fieldsEntities;

    public function __construct(array $fields, array $data)
    {
        $fieldsEntities = [];
        foreach ($fields as $field) {
            $className = ucfirst(mb_strtolower($field['type']));
            $namespace = "\Jtrw\Store\Fields\\".$className;
            $field['value'] = $data[$field['name']] ?? null;
            $fieldsEntities[] = new $namespace($field);
        }
        $this->_fieldsEntities = $fieldsEntities;
    } // end __construct

    public function getValues(): array
    {
        $values = [];
        foreach ($this->_fieldsEntities as $fieldEntity) {
            $values[$fieldEntity->getName()] = $fieldEntity->getValue();
        }

        return $values;
    }

}
