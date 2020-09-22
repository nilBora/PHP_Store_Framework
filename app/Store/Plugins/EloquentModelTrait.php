<?php

namespace NilBora\NSF\Store\Plugins;

trait EloquentModelTrait
{
    protected $actions = [
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
    }
    
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
