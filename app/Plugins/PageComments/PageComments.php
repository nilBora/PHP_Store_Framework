<?php
namespace App\Plugins\PageComments;

use Illuminate\Database\Eloquent\Model;
use NilBora\NSF\Store\Plugins\EloquentModelTrait;
use NilBora\NSF\Store\Plugins\ICustomModel;

class PageComments extends Model implements ICustomModel
{
    use EloquentModelTrait;
    protected $table = 'page_comments';
    
    
    protected $fields = [
        "name"    => [
            "type"    => "text",
            "name"    => "name",
            "caption" => "Name Comment"
        ],
        "body"    => [
            "type"    => "textarea",
            "name"    => "body",
            "caption" => "Body"
        ],
    ];
}
