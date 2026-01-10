<?php

namespace FedexRest\Entity;

/**
 * Item entity class for storing package/line item information
 * Used to describe the contents and weight of a shipment
 */
class Item
{
    public string $itemDescription = '';
    public ?Weight $weight;

    /**
     * Set the item description
     *
     * @param  string  $itemDescription  Description of the item/package contents
     * @return Item
     */
    public function setItemDescription(string $itemDescription): Item
    {
        $this->itemDescription = $itemDescription;
        return $this;
    }

    /**
     * Set the weight of the item
     *
     * @param  Weight|null  $weight  Weight object with unit and value
     * @return Item
     */
    public function setWeight(?Weight $weight): Item
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * Prepare item data for API request
     *
     * @return array  Formatted item data array for FedEx API
     */
    public function prepare(): array
    {
        return [
            [
                'itemDescription' => $this->itemDescription,
                'weight' => [
                    'units' => $this->weight->unit,
                    'value' => $this->weight->value,
                ],
            ]
        ];
    }


}
