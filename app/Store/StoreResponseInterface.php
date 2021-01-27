<?php
namespace Jtrw\Store;

interface StoreResponseInterface
{
    public function getJson(): string;
    public function getData(): array;
    public function getSourceData();

}
