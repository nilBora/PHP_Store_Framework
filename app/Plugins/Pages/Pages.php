<?php

namespace App\Plugins\Pages;

use App\Plugins\PageComments\PageComments;
use Jtrw\Store\Model\StoreEloquentModel;

class Pages extends StoreEloquentModel
{
    protected $table = 'pages';

    protected $fillable = ['name'];

    protected $with = [
        'type',
        'comments'
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
