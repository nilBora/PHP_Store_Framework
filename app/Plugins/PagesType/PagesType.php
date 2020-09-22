<?php
namespace App\Plugins\PagesType;

use Illuminate\Database\Eloquent\Model;
use NilBora\NSF\Store\Plugins\EloquentModelTrait;
use NilBora\NSF\Store\Plugins\ICustomModel;

class PagesType extends Model implements ICustomModel
{
    use EloquentModelTrait;
    
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
