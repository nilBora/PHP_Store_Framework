<?php

namespace Jtrw\Store\Fields;

abstract class AbstractFieldType implements FieldTypeInterface
{
    protected array $field;

    public function __construct(array $filed)
    {
        $this->field = $filed;
    } // __construct

    public function getName(): string
    {
        return $this->field['name'];
    } // getName

    public function getValue()
    {
        return $this->field['value'];
    } // end getValue

    public function getRegExp()
    {
        if (array_key_exists('regExp', $this->field)) {
            return $this->field['regExp'];
        }

    } // end getValue

    public function doValidate(): ?array
    {
        if ($regExp = $this->getRegExp()) {

            if (!preg_match($regExp, $this->getValue())) {
                return [
                    'name' => $this->getName(),
                    'error' => sprintf("RegExp: '%s' Error!", $regExp)
                ];
            }

        }

        return null;
    }
}
