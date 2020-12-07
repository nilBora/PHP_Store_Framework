<?php
namespace Jtrw\Store\Model;

interface CustomModelInterface
{
    public function onList(array $search = []): array;
    public function onRow(array $search): ?array;
    public function onInsert(array $values);
    public function getStruct(): array;
    public function pagination(object $query): array;
    public function onUpdate(array $values, array $search): array;
    public function onRemove(array $search): bool;
}
