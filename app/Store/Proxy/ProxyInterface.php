<?php
namespace NilBora\NSF\Store\Proxy;
interface ProxyInterface
{
    public function search(string $tableName);
    public function select(string $sql, array $params = []);
    public function build(string $tableName, array $select, array $search, array $orderBy, array $join, bool $isFirst = false, int $rowsPerPage = null, $options = []);
    public function add(string $tableName, array $values);
    public function update(string $tableName, array $values, array $search);
    public function remove(string $tableName, array $search);
}
