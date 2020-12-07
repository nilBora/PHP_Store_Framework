<?php
namespace Jtrw\Store;

use Jtrw\Store\Model\CustomModelInterface;
use Jtrw\Store\Proxy\ProxyInterface;

interface StoreModelInterface
{
    public function load(): array;
    public function getStruct(): array;
    public function getStore(): StoreInterface;
    public function getFields(): array;
    public function hasKeyInStruct(string $key): bool;
    public function getTableName(): string;
    public function getProxy(): ProxyInterface;
    public function hasModelFile(): bool;
    public function getCustomModel(): CustomModelInterface;
}
