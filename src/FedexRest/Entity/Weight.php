<?php

namespace FedexRest\Entity;

/**
 * Weight entity class for storing weight information
 * Used for package weight in shipments
 */
class Weight
{
    public string $unit = '';
    public string $value = '';

    /**
     * Set the weight unit (e.g., 'LB' for pounds, 'KG' for kilograms)
     *
     * @param  string  $unit  Weight unit (LB, KG, etc.)
     * @return Weight
     */
    public function setUnit(string $unit): Weight
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * Set the weight value
     *
     * @param  int  $value  Weight value as an integer
     * @return Weight
     */
    public function setValue(int $value): Weight
    {
        $this->value = $value;
        return $this;
    }


}
