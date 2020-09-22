<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use NilBora\NSF\Store\Exceptions\ApiException;
use NilBora\NSF\Store\Request\LaravelRequest;
use NilBora\NSF\Store\Store;
use NilBora\NSF\Store\Proxy\LaravelProxy;
use NilBora\NSF\Events\Event;

class ApiDefault extends Controller
{
    protected $options;
    
    public function __construct()
    {
        $options = [
            'plugins_dir'       => app_path('Plugins')."/",
            'plugins_namespace' => '\App\Plugins'
        ];
        $this->options = $options;
    } // end __construct
    
    protected function createStore(string $name, Request $request = null)
    {
        if (!$request) {
            $request = new Request();
        }
        
        return new Store($name, new LaravelRequest($request), new LaravelProxy(), new Event(), $this->options);
    } // end createStore
    
    public function index(Request $request, string $name)
    {
        $store = $this->createStore($name, $request);
        $response = $store->createActionList();
        return response()->json($response->getData());
    } // end index
    
    public function show(string $name, int $id)
    {
        $store = $this->createStore($name);
        $response = $store->createActionInfo($id);
        $result = $response->getData();
        if (empty($result['data']['item'])) {
            return response()->json($result, 404);
        }
        
        return response()->json($result);
    } // end show
    
    public function store(Request $request, string $name)
    {
        $store = $this->createStore($name, $request);
        $response = $store->createActionInsert();
       
        return response()->json($response->getData(), 201);
    } // end store
    
    public function update(Request $request, string $name, int $id)
    {
        $store = $this->createStore($name, $request);
        $response = $store->createActionEdit($id);
        
        return response()->json($response->getData());
    } // end update
    
    public function remove(string $name, int $id)
    {
        $store = $this->createStore($name);
        $response = $store->createActionRemove($id);
        return response()->json($response->getData(), 201); //XXX: fix this 204
    } // end destroy
}
