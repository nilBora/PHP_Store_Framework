<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jtrw\Events\EventManager;
use Jtrw\Store\Proxy\LaravelProxy;
use Jtrw\Store\Request\LaravelRequest;
use Jtrw\Store\Store;
use Jtrw\StoreUtils\StoreCreateTrait;
use Jtrw\StoreView\Menu;
use Jtrw\StoreView\MenuInterface;
use Jtrw\StoreView\StoreView;

class DashboardController extends Controller
{
    use StoreCreateTrait;

    public function __construct()
    {
        $options = [
            'plugins_dir'       => app_path('Plugins')."/",
            'plugins_namespace' => '\App\Plugins'
        ];

        $this->setStoreOptions($options);

    } // end __construct

    public function index(Request $request, string $name)
    {
        $store = $this->createStore($name);
        $response = $store->actionStart("List", $request);

        $storeView = new StoreView($name, $response);

        $notification = null;

        return view(
            'table',
            [
                'response'     => $response->getData(),
                'view'         => $storeView,
                'notification' => $notification,
                'sidebar'      => $this->_getSideBar($request->getRequestUri())
            ]
        );
    }

    private function _getSideBar(string $currentUri): MenuInterface
    {
        $store = $this->createStore("menu");
        $response = $store->actionStart("List");
        $items = $response->getData()['data']['items'];

        return new Menu($items, $currentUri);
    }

}
