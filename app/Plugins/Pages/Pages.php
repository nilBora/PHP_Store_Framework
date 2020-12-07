<?php

namespace App\Plugins\Pages;

use App\Plugins\PageComments\PageComments;
use Jtrw\Store\Model\StoreEloquentModel;

class Pages extends StoreEloquentModel
{
    protected $table = 'pages';
    
    protected $with = [
        'type',
        'comments'
    ];
    
    protected $fields = [
        "id_type"  => [
            "type"              => "foreignKey",
            "foreignTable"      => "pages_type",
            "alias"             => "type",
            "foreignKeyField"   => "id",
            "foreignValueField" => "name",
            "name"              => "id_type",
            "caption"           => "Type"
        ],
        "name"     => [
            "type"    => "text",
            "name"    => "name",
            "caption" => "Page NAme"
        ],
        "body"     => [
            "type"    => "textarea",
            "name"    => "body",
            "caption" => "Body Text"
        ],
        "comments" => [
            "name"              => "comments",
            "type"              => "many2many",
            "caption"           => "Relation",
            "linkTable"         => "page2comments",
            "linkField"         => "id_page",
            "linkForeignField"  => "id_comment",
            "foreignTable"      => "page_comments",
            "foreignKeyField"   => "id",
            "foreignValueField" => "name"
        ]
    ];
    
    public $actions = [
        "list"   => [
            "type"    => "list",
            "caption" => "Pages"
        ],
        "edit"   => [
            "type"    => "edit",
            "caption" => "Edit Page ID#%id%"
        ],
        "remove" => [
            "type"    => "remove",
            "caption" => "Delete"
        ]
    ];
    
    
    public function type()
    {
        return $this->belongsTo(\App\Plugins\PagesType\PagesType::class, 'id_type', 'id');
    } // end type
    
    public function comments()
    {
        return $this->belongsToMany(
            PageComments::class,
            'page2comments',
            'id_page',
            'id_comment'
        );
        //->withPivot('id', 'created_user_id', 'updated_user_id')
        //    ->withTimestamps();
    } // end statusHistory
    
}
