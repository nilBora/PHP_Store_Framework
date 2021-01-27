<?php

namespace Jtrw\Store\Fields;

interface FieldTypeInterface
{
    public function getName(): string;
    public function getValue();
}
