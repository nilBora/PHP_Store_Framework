<?php

namespace Jtrw\Store\Model;

use App\Plugins\PageComments\PageComments;
use Illuminate\Database\Eloquent\Model;

class StoreEloquentModel extends Model implements CustomModelInterface
{
    protected $fillable = [];
    protected $fields = [];
    protected $isSoftDelete = false;
    protected $orderByColumn = 'id';
    protected $orderByDirection = 'ASC';

    protected $table = [];

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

    public function __construct(array $attributes = [], array $struct = [])
    {
        if (array_key_exists('fields', $struct)) {
            $this->fields = $struct['fields'];
        }
        if (array_key_exists('actions', $struct)) {
            $this->actions = $struct['actions'];
        }
        if (array_key_exists('table', $struct)) {
            $this->table = $struct['table'];
        }

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

    public function onList(array $search = []): array
    {
        $query = static::with($this->with)->where($search)->orderBy($this->orderByColumn, $this->orderByDirection);

        return $this->pagination($query);
    } // end onList

    public function onRow(array $search): ?array
    {
        $row = static::with($this->with)->where($search)->first();
        if (!$row) {
            return null;
        }
        return $row->toArray();
    } // end onRow

    public function onInsert(array $values): array
    {
        $class = $this->_getCalledClass();

        $model = new $class($values);

        $model->save();

        $model = $this->onSyncFields($model, $values);

        $model->refresh();
        return $model->toArray();
    } // end onInsert

    public function getStruct(): array
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

    public function pagination(object $query): array
    {
        $result = $query->get();
        $rowsData = null;
        if ($result) {
            $rowsData = $result->toArray();
        }
        $toReturn = [
            'items'       => $rowsData,
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
                'items'       => $paginationModel->items()->toArray(),
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

    public function onUpdate(array $values, array $search): array
    {
        $model =  static::with([])->where($search)->first();

        $model = $this->onSyncFields($model, $values);

        $model->fill($values);
        $model->save();
        $model->refresh();

        return $this->onRow($search);
    } // end onUpdate

    public function onRemove(array $search): bool
    {
        $model = static::with([])->where($search)->first();
        if ($this->isSoftDelete) {
            $model->is_deleted = true;
            //$this->is_active = false;
            return $model->save();
        }

        return $model->delete();
    } // end onRemove

    private function _getCalledClass(): string
    {
        return get_called_class();
    } // end _getCalledClass

    protected function onSyncFields(Model $model, array $values): Model
    {
        foreach ($this->fields as $fieldName => $field) {
            if ($field['type'] === 'many2many' && isset($values[$field['name']])) {
                $currentValues = $values[$field['name']];
                $model->{$field['name']}()->sync($currentValues);
            }
        }
        return $model;
    } // end onSyncFields
}
