<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Jtrw\Events\EventManager;
use Jtrw\Store\Exceptions\ApiException;
use Jtrw\Store\Exceptions\FieldValidationException;
use Jtrw\Store\Proxy\LaravelProxy;
use Jtrw\Store\Request\LaravelRequest;
use Jtrw\Store\Store;

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

        $eventDispatcher = new EventManager();
        //$eventDispatcher->addListener(Store::HOOK_BEFORE_LIST, [new ShortenerController(), 'onBeforeList']);

        return new Store($name, new LaravelRequest($request), new LaravelProxy(), $eventDispatcher, $this->options);
    } // end createStore

    public function index(Request $request, string $name)
    {
        $store = $this->createStore($name, $request);
        $response = $store->actionStart("List");

        return response()->json($response->getData());
    } // end index

    public function show(Request $request, string $name, int $id)
    {
        $store = $this->createStore($name, $request);
        $response = $store->actionStart("Info", ['ID' => $id]);

        $result = $response->getData();
        if (empty($result['data']['item'])) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    } // end show

    public function store(Request $request, string $name)
    {
        $store = $this->createStore($name, $request);
        $response = $store->actionStart("Insert");

        return response()->json($response->getData(), 201);
    } // end store

    public function update(Request $request, string $name, int $id)
    {
        try {
            $store = $this->createStore($name, $request);
            $response = $store->actionStart("Edit", ['ID' => $id]);
        } catch (ApiException $exp) {
            $response = [
                'status'  => 'error',
                'type'    => 'api',
                'message' => $exp->getMessage()
            ];
            return response()->json($response);
        } catch (FieldValidationException $exp) {
            $response = [
                'status'  => 'error',
                'type'    => 'field',
                'fields'  => $exp->getMessage()
            ];
            return response()->json($response);
        }

        return response()->json($response->getData());
    } // end update

    public function remove(string $name, int $id)
    {
        $store = $this->createStore($name);
        $response = $store->actionStart("Remove", ['ID' => $id]);

        return response()->json($response->getData(), 201); //XXX: fix this 204
    } // end destroy
}
