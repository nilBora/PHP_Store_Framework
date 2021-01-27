<?php

namespace Jtrw\StoreView;

use Jtrw\Utils\ValuesObject;

class MenuItem extends ValuesObject implements MenuItemInterface
{
    private string $_currentUrl;

    public function __construct(array $item, string $currentUrl = null)
    {
        $this->_currentUrl = $currentUrl;
        parent::__construct($item);
    } // end __construct

    public function isActive(): bool
    {
        return $this->_currentUrl === $this->getHref();
    } // end isActive

    public function getHref(): string
    {
        return $this->get('href');
    } // end getHref

    public function getCaption(): string
    {
        return $this->get('caption');
    } // end getCaption

    public function getItems(): ?array
    {
        return $this->get('items');
    } // end getItems

    public function hasItems(): bool
    {
        return !empty($this->get('items'));
    } // end hasItems

    public function hasIcon(): bool
    {
        return !empty($this->get('icon'));
    } // end getIcon

    public function getIcon(): string
    {
        return $this->get('icon');
    } // end getIcon

    public function hasLabel(): bool
    {
        return $this->has('label');
    } // end hasLabel

    public function getLabel(): string
    {
        return $this->get('label');
    } // end getLabel
}
