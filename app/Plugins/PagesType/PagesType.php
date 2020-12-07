<?php
namespace App\Plugins\PagesType;

use Jtrw\Store\Model\StoreEloquentModel;

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
    
    public function onList(array $search = []): array
    {
        $query = static::where('id', '>', 0);
        
        return $this->pagination($query);
    }
    
}
