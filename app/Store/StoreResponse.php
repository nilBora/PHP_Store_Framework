<?php

namespace NilBora\NSF\Store;

class StoreResponse
{
    const RESPONSE_STATUS_SUCCESS = "success";
    const FIELD_NAME_ITEMS        = "items";
    const FIELD_NAME_ITEM         = "item";
    
    protected $data;
    protected $model;
    protected $options;
    
    /**
     * StoreResponse constructor.
     * @param array|\stdClass $data
     * @param IStoreModel $model
     * @param array $options
     */
    public function __construct($data, IStoreModel $model, array $options = [])
    {
        $this->data = $data;
        $this->model = $model;
        $this->options = $options;
    } // end __construct
    
    public function getJson()
    {
        return json_encode($this->getData());
    } // end getJson
    
    public function getData()
    {
        $items = $this->getSourceData();
        
        $itemsReturn = $items;
        $struct = $this->model->getStruct();
        
        //XXX: Fix this pyramid
        if (empty($this->options['isCustom'])) {
            $itemsFieldName = static::FIELD_NAME_ITEM;
    
            if (!is_object($items) && !empty($items['items']) && is_array($items['items'])) {
                $itemsFieldName = static::FIELD_NAME_ITEMS;
                $items['items'] = $this->getPreparedValues($items['items']);
            }
    
            if (is_object($items)) {
                $this->setCheckSumInRow($items);
            }
    
            $struct['fields'][Store::FIELD_CHECK_SUM] = [
                'name' => Store::FIELD_CHECK_SUM,
                'type' => Store::FIELD_CHECK_SUM
            ];
    
            $itemsReturn = [$itemsFieldName => $items];
            if (!is_object($items) && !empty($items['items'])) {
                $itemsReturn = $items;
            }
            
        }
        
        
        $returnData = [
            'status' => static::RESPONSE_STATUS_SUCCESS,
            'data'   => [
                'struct' => $struct
            ]
        ];
        
        $returnData['data'] = array_merge($itemsReturn, $returnData['data']);

        return $returnData;
    } // end getData
    
    public function getSourceData()
    {
        return $this->data;
    } // end getSourceData
    
    protected function getPreparedValues(array $values)
    {
        foreach ($values as $itemKey => $item) {
            if (!is_object($item)) {
                continue;
            }
            $this->setCheckSumInRow($item);
        }
        
        return $values;
    } // end getPreparedValues
    
    protected function setCheckSumInRow(\stdClass $class)
    {
        $class->CHECK_SUM = md5(json_encode($class));
    } // end setCheckSumInRow
}