<?php
namespace Jtrw\Store\Actions;
use Jtrw\Store\StoreResponseInterface;

interface ActionInterface
{
    public function onStart(): StoreResponseInterface;
}
