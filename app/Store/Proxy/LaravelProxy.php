<?php
namespace NilBora\NSF\Store\Proxy;

use Illuminate\Support\Facades\DB;

class LaravelProxy implements IProxy
{
    public function search(string $tableName)
    {
        return DB::table($tableName)->get()->toArray();
    } // end search
    
    public function select(string $sql, array $params = [])
    {
        return DB::select($sql, $params);
    } // end select
    
    public function build(string $tableName, array $select, array $search, array $orderBy, array $join, bool $isFirst = false, int $rowsPerPage = null, $options = [])
    {
        
        $query = DB::table($tableName);
        
        if ($select) {
            foreach ($select as $key => $row) {
                if (strstr($row, ".") === false) {
                    $select[$key] = $tableName.".".$row;
                }
                
            }
            if (!in_array($tableName.".id", $select) || !in_array("id", $select)) {
                array_unshift($select, $tableName.".id");
            }

            $query->select($select);
        }
        
        if (!empty($options['join'])) {
            foreach ($options['join'] as $joinRow) {
                $query->join($joinRow[0], $joinRow[1], $joinRow[2], $joinRow[3]);
            }
            
        }
        
        if ($orderBy) {
            foreach ($orderBy as $value) {
                $rows = explode(",", $value);
                foreach ($rows as $row) {
                    $chunks = explode(" ", $row);
                    $query->orderBy($chunks[0], $chunks[1]);
                }
               
            }
            
        }
        
        if ($search) {
            $query->where($search);
        }
        
        if ($isFirst) {
            return $query->first();
        }
    
        $toReturn = [
            'items'       => $query->get(),
            'pagination'  => [
                'total_items' => $query->count($tableName.'.id'),
                'total_pages' => 1,
                'from'        => 1,
                'to'          => 1,
            ]
            
        ];
        
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
        //return $query->get()->toArray();
    } // end build
    
    public function add(string $tableName, array $values)
    {
        return DB::table($tableName)->insertGetId($values);
    } // end add
    
    public function update(string $tableName, array $values, array $search)
    {
        return DB::table($tableName)->where($search)->update($values);
    } // end update
    
    public function remove(string $tableName, array $search)
    {
        return DB::table($tableName)->where($search)->delete();
    } // end delete
}
