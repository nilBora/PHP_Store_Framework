<?php
namespace NilBora\NSF\Store;

use NilBora\NSF\Store\Actions\ActionInterface;
use NilBora\NSF\Store\Proxy\ProxyInterface;

interface StoreInterface
{
    public function createActionInstance(string $actionName, array $options = []): ActionInterface;
    public function actionStart(string $actionName, array $options = []): SoreResponseInterface;
    public function getOptions(): array;
    public function getTableName(): string;
    public function addListener(string $name, array $data);
    public function getProxy(): ProxyInterface;
}
