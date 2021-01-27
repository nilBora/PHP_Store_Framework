<?php

namespace Jtrw\Store;

class StoreResponse implements StoreResponseInterface
{
    const RESPONSE_STATUS_SUCCESS = "success";
    const FIELD_NAME_ITEMS        = "items";
    const FIELD_NAME_ITEM         = "item";

    protected $data;
    protected $model;
    protected $options;

    /**
     * StoreResponse constructor.
     * @param StoreModelInterface $model
     * @param array|null $data
     * @param array $options
     */
    public function __construct(StoreModelInterface $model, array $data = null, array $options = [])
    {
        $this->data = $data;
        $this->model = $model;
        $this->options = $options;
    } // end __construct

    public function getJson(): string
    {
        return json_encode($this->getData());
    } // end getJson

    public function getData(): array
    {
        $items = $this->getSourceData();

        $itemsReturn = $items;
        $struct = $this->model->getStruct();

        //XXX: Fix this pyramid
        if (empty($this->options['isCustom'])) {
            $itemsFieldName = static::FIELD_NAME_ITEM;

            if (!empty($items['items']) && is_array($items['items'])) {
                $itemsFieldName = static::FIELD_NAME_ITEMS;
                $items['items'] = $this->getPreparedValues($items['items']);
            } else if (is_array($items)) {
                $this->setCheckSumInRow($items);
            }

            $struct['fields'][Store::FIELD_CHECK_SUM] = [
                'name'    => Store::FIELD_CHECK_SUM,
                'type'    => "hidden",
                'caption' => "CHECK_SUM" //XXX: FIX it
            ];

            $itemsReturn = [$itemsFieldName => $items];
            if (!empty($items['items'])) {
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

    protected function getPreparedValues(array $values): array
    {
        foreach ($values as $itemKey => $item) {
            $this->setCheckSumInRow($item);
        }

        return $values;
    } // end getPreparedValues

    protected function setCheckSumInRow(array &$item)
    {
        $item['CHECK_SUM'] = md5(json_encode($item));
    } // end setCheckSumInRow
}
