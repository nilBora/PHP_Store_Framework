<?php
namespace Jtrw\StoreView;

interface MenuItemInterface
{
    public function isActive(): bool;
    public function getHref(): string;
    public function getCaption(): string;
    public function getItems(): ?array;
    public function hasItems(): bool;
    public function getIcon(): string;
    public function hasIcon(): bool;
    public function hasLabel(): bool;
    public function getLabel(): string;
}
