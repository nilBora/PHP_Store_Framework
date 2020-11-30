<?php
namespace NilBora\NSF\Store\Model;

interface CustomModelInterface
{
    public function onList(array $search = []);
    public function onRow(array $search);
    public function onInsert(array $values);
    public function getStruct();
    public function pagination(object $query);
    public function onUpdate(array $values, array $search);
    public function onRemove(array $search);
}
