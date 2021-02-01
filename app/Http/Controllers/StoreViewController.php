<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jtrw\Events\EventManager;
use Jtrw\Store\Proxy\LaravelProxy;
use Jtrw\Store\Request\LaravelRequest;
use Jtrw\Store\Store;
use Jtrw\StoreUtils\StoreCreateTrait;
use Jtrw\StoreView\FieldEntity;
use Jtrw\StoreView\StoreView;

class StoreViewController extends Controller
{
    use StoreCreateTrait;

    protected array $options;

    public function __construct()
    {
        $options = [
            'plugins_dir'       => app_path('Plugins')."/",
            'plugins_namespace' => '\App\Plugins'
        ];
        $this->setStoreOptions($options);
    } // end __construct

    public function show(Request $request, string $name, int $id)
    {
        $store = $this->createStore($name);
        $options = [
            'ID' => $id
        ];
        $response = $store->actionStart("Info", $request, $options);

        $itemEntity = new FieldEntity($response->getData()['data']['item'], $response->getData()['data']['struct']['fields'], new LaravelProxy());

        return view('form.popup_form', ['itemEntity' => $itemEntity]);
    } // end index

    public function onShowEmptyForm(Request $request, string $name)
    {
        $store = $this->createStore($name);
        $struct = $store->getModel()->load();

        $fields = array_fill_keys(array_keys($struct['fields']), "");

        $itemEntity = new FieldEntity($fields, $struct['fields'], new LaravelProxy());

        return view('form.popup_form', ['itemEntity' => $itemEntity]);
    } // end onShowEmptyForm
}
