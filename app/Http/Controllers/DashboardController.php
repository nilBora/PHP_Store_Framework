<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jtrw\Events\EventManager;
use Jtrw\Store\Proxy\LaravelProxy;
use Jtrw\Store\Request\LaravelRequest;
use Jtrw\Store\Store;
use Jtrw\StoreView\StoreView;

class DashboardController extends Controller
{
    protected array $options;
    
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
        
        $storeView = new StoreView($name, $response);
        
        $notification = null;
        
        return view(
            'table',
            [
                'response' => $response->getData(),
                'view' => $storeView,
                'notification' => $notification
            ]
        );
    }
}
