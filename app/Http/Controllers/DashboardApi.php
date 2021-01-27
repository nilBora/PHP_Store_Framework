<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jtrw\Store\Exceptions\ApiException;

class DashboardApi extends ApiDefault
{
    public function index(Request $request, string $name)
    {
        return parent::index($request, $name);
    } // end index

    public function show(Request $request, string $name, int $id)
    {
        return parent::show($request, $name, $id);
    } // end show

    public function store(Request $request, string $name)
    {
        return parent::store($request, $name);
    } // end store

    public function update(Request $request, string $name, int $id)
    {
        return parent::update($request, $name, $id);
    } // end update

    public function remove(string $name, int $id)
    {
        return parent::remove($name, $id);
    } // end remove
}
