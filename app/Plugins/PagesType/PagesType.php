<?php
namespace App\Plugins\PagesType;

use NilBora\NSF\Store\Plugins\StoreEloquentModel;

class PagesType extends StoreEloquentModel
{
    protected $table = 'pages_type';
    
    
    protected $fields = [
        "name"    => [
            "type"    => "text",
            "name"    => "name",
            "caption" => "Type Name"
        ],
    ];
    
    public function onList()
    {
        $query = static::where('id', '>', 0);
        
        return $this->pagination($query);
    }
    
}
