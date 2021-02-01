<?php
namespace Jtrw\Store;

use Jtrw\Store\Actions\ActionInterface;
use Jtrw\Store\Proxy\ProxyInterface;
use Symfony\Component\HttpFoundation\Request;

interface StoreInterface
{
    public function createActionInstance(string $actionName, Request $request, array $options = []): ActionInterface;
    public function actionStart(string $actionName, Request $request, array $options = []): StoreResponseInterface;
    public function getOptions(): array;
    public function getTableName(): string;
    public function addListener(string $name, array $data);
    public function getProxy(): ProxyInterface;
    public function getModel(): StoreModelInterface;
}
