<?php

namespace NilBora\NSF\Store\Plugins;

use Illuminate\Database\Eloquent\Model;

class StoreEloquentModel extends Model implements CustomModelInterface
{
    //protected $with = [];
    
    public $actions = [
        "list"   => [
            "type"    => "list",
            "caption" => "Pages"
        ],
        "edit"   => [
            "type"    => "edit",
            "caption" => "Edit Field ID#%id%"
        ],
        "remove" => [
            "type"    => "remove",
            "caption" => "Delete"
        ]
    ];
    
    public function onList()
    {
        $query = new self();
        
        return $this->pagination($query);
    } // end onList
    
    public function onRow($search)
    {
        return static::with($this->with)->where($search)->first();
    } // end onRow
    
    public function onInsert(array $values)
    {
        $model = new self($values);
        $model->save();
        $model->refresh();
        return $model;
    } // end onInsert
    
    public function getStruct()
    {
        return [
            "table"   => [
                "name"       => $this->table,
                "primaryKey" => "id"
            ],
            "fields"  => $this->fields,
            "actions" => $this->actions
        
        ];
    } // end getStruct
    
    public function pagination($query)
    {
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
        $rowsPerPage = $struct['table']['rowsPerPage'] ?? null;
        
        if ($rowsPerPage) {
            $paginationModel = $query->paginate($rowsPerPage);
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
}
