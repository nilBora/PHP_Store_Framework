<?php
namespace App\Plugins\PageComments;

use Jtrw\Store\Model\StoreEloquentModel;

class PageComments extends StoreEloquentModel
{
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
