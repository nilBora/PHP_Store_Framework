<?php

namespace App\Plugins\Menu;

use Jtrw\Store\Model\StoreEloquentModel;

class Menu extends StoreEloquentModel
{
    protected $table = "festi_menus";
    protected $orderByColumn = "order_n";
    protected $orderByDirection = "ASC";
    
    protected $fields = [
        "caption"   => [
            "type"    => "text",
            "name"    => "caption",
            "caption" => "Host"
        ],
        "url"       => [
            "type"    => "text",
            "name"    => "url",
            "caption" => "Link"
        ],
        "id_parent" => [
            "type"    => "text",
            "name"    => "id_parent",
            "caption" => "ID parent",
        ],
        "order_n"   => [
            "type"    => "text",
            "name"    => "order_n",
            "caption" => "Order"
        ],
        "icon"      => [
            "type"    => "text",
            "name"    => "icon",
            "caption" => "Icon"
        ]
    ];
}
