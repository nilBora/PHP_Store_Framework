<?php

namespace Jtrw\Store\Request;

use Illuminate\Http\Request;

class LaravelRequest implements StoreRequestInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    } // end __construct

    public function all()
    {
        return $this->request->all();
    } // end all

    public function getRequest()
    {
        return $this->request;
    }

}
