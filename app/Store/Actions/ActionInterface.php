<?php
namespace NilBora\NSF\Store\Actions;
use NilBora\NSF\Store\Request\StoreRequestInterface;

interface ActionInterface
{
    public function onStart(): StoreRequestInterface;
}
