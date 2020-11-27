<?php

namespace NilBora\NSF\Store\Plugins;

use Illuminate\Database\Eloquent\Model;

class StoreEloquentModel extends Model implements CustomModelInterface
{
    protected $fillable = [];
    protected $fields = [];
    protected $isSoftDelete = false;
    
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
    
    public function __construct(array $attributes = [])
    {
        foreach ($this->fields as $fieldName => $row) {
            if ($row['type'] == 'many2many') {
                continue;
            }
            $this->fillable[] = $fieldName;
        }
        
        if (!array_search('updated_at', $this->fillable)) {
            array_push($this->fillable, 'updated_at');
        }
        

        parent::__construct($attributes);
    } // end __construct
    
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
        $class = get_called_class();

        $model = new $class($values);
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
    } // end pagination
    
    public function onUpdate($values, $search)
    {
        $model =  static::where($search)->first();
        $model->fill($values);
        $model->save();
        
        return $this->onRow($search);
    } // end onUpdate
    
    public function onRemove($search)
    {
        $model = static::where($search)->first();
        if ($this->isSoftDelete) {
            $model->is_deleted = true;
            //$this->is_active = false;
            return $model->save();
        }
    
        return $model->delete();
    } // end onRemove
}
