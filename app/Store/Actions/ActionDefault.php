<?php
namespace Jtrw\Store\Actions;

use Jtrw\Events\EventManagerInterface;
use Jtrw\Store\Proxy\ProxyInterface;
use Jtrw\Store\Request\StoreRequestInterface;
use Jtrw\Store\StoreModelInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class ActionDefault
{
    protected StoreModelInterface $model;
    protected string $primaryKey = 'id';
    protected string $primaryKeyValue;
    protected EventManagerInterface $event;
    protected Request $request;
    protected ProxyInterface $proxy;
    protected array $options;

    public function __construct(StoreModelInterface $model, ProxyInterface $proxy, EventManagerInterface $event, Request $request = null, array $options = [])
    {
        $this->model = $model;
        $this->event = $event;
        $this->request = $request;
        $this->proxy = $proxy;
        $this->options = $options;

        if (array_key_exists('ID', $options)) {
            $this->primaryKeyValue = $options['ID'];
        }
    }

    protected function getPreparedValues(array $values)
    {
        foreach ($values as $itemKey => $item) {
            $item->CHECK_SUM = md5(json_encode($item));
        }

        return $values;
    } // end getPreparedValues
}
