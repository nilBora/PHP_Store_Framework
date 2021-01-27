<?php

namespace Jtrw\Store\Fields;

use Jtrw\Store\Exceptions\FieldValidationException;

class FieldsFactory implements FieldsFactoryInterface
{
    private array $_fieldsEntities;

    public function __construct(array $fields, array $data)
    {
        $fieldsEntities = [];
        $errors = [];
        foreach ($fields as $field) {
            $className = ucfirst(mb_strtolower($field['type']));
            $namespace = "\Jtrw\Store\Fields\\".$className;
            $field['value'] = $data[$field['name']] ?? null;
            $filedEntity = new $namespace($field);

            if ($error = $filedEntity->doValidate()) {
                $errors[] = $error;
            }

            $fieldsEntities[] = $filedEntity;
        }
        if ($errors) {
            throw new FieldValidationException(json_encode($errors));
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
