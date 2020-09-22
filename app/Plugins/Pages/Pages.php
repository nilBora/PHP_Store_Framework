<?php

namespace App\Plugins\Pages;

use App\Plugins\PageComments\PageComments;
use Illuminate\Database\Eloquent\Model;
use NilBora\NSF\Store\Plugins\EloquentModelTrait;
use NilBora\NSF\Store\Plugins\ICustomModel;

class Pages extends Model implements ICustomModel
{
    use EloquentModelTrait;
    
    protected $table = 'pages';
    
    private static $_with = [
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
    
    
    public function onList()
    {
        $query = static::with(static::$_with);
        $toReturn = [
            'items'       => $query->get(),
            'pagination'  => [
                'total_items' => $query->count('.id'),
                'total_pages' => 1,
                'from'        => 1,
                'to'          => 1,
            ]
    
        ];
        $struct = $this->getStruct();
        if (!empty($struct['table']['rowsPerPage'])) {
            $paginationModel = $query->paginate($struct['table']['rowsPerPage']);
            $toReturn = [
                'items'       => $paginationModel->items(),
                'pagination'  => [
                    'total_items' => $paginationModel->total(),
                    'total_pages' => $paginationModel->lastPage(),
                    'from'        => $paginationModel->firstItem(),
                    'to'          => $paginationModel->lastItem(),
                ]
        
            ];
        }
        return $toReturn;
    }
    
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
