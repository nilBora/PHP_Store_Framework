<?php
namespace NilBora\NSF\Store\Actions;
use NilBora\NSF\Store\SoreResponseInterface;

interface ActionInterface
{
    public function onStart(): SoreResponseInterface;
}
