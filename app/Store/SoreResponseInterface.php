<?php
namespace NilBora\NSF\Store;

interface SoreResponseInterface
{
    public function getJson(): string;
    public function getData(): array;
    public function getSourceData();
    
}
