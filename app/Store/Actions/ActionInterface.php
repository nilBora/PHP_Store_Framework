<?php
namespace Jtrw\Store\Actions;
use Jtrw\Store\SoreResponseInterface;

interface ActionInterface
{
    public function onStart(): SoreResponseInterface;
}
