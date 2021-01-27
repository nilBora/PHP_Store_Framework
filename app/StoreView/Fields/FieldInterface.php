<?php

namespace Jtrw\StoreView\Fields;

interface FieldInterface
{
    public function isHide(): bool;
    public function getName(): string;
    public function getCaption(): string;
    public function getClassName(): string;
}
