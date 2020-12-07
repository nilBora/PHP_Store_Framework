<?php
namespace Jtrw\Store;

interface SoreResponseInterface
{
    public function getJson(): string;
    public function getData(): array;
    public function getSourceData();
    
}
