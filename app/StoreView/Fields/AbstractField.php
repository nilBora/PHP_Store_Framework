<?php

namespace Jtrw\StoreView\Fields;

use Jtrw\Store\Proxy\ProxyInterface;
use Jtrw\StoreView\Exceptions\FieldNotFoundPropertyException;

abstract class AbstractField
{
    protected array $options;
    protected ?ProxyInterface $proxy;

    public function __construct(array $options, ProxyInterface $proxy = null)
    {
        $this->options = $options;
        $this->proxy = $proxy;
    }

    public function isHide(): bool
    {
        return $this->options['type'] == 'hidden' || (isset($this->options['hide']) && $this->options['hide'] === true);
    } // end isHide

    /**
     * @param string|int|float $key
     * @return string
     * @throws FieldNotFoundPropertyException
     */
    protected function get(string $key)
    {
        if (!array_key_exists($key, $this->options)) {
            throw new FieldNotFoundPropertyException($key);
        }

        return $this->options[$key];
    }

    protected function has(string $key): bool
    {
        return array_key_exists($key, $this->options);
    }

    protected function set(string $key, $value)
    {
        $this->options[$key] = $value;
    }

    public function getName(): string
    {
        return $this->get('name');
    }

    public function getCaption(): string
    {
        return $this->get('caption');
    }

    /**
     * @return string|int|float
     * @throws FieldNotFoundPropertyException
     */
    public function getValue()
    {
        return $this->get('value');
    }

    public function setValue($value)
    {
        $this->set('value', $value);
    }

    public function fetchByList()
    {
        return $this->getValue();
    }

    public function fetchByEdit()
    {
        //
    }

    public function fetchByInfo()
    {
        return $this->getValue();
    }

    public function getClassName(): string
    {
        //TODO: ADD Store Name;
        return "js-store-".$this->getName();
    } // end getClassName

    public function hasSearch()
    {
        return $this->has('search') && $this->get('search') === true;
    }
}
