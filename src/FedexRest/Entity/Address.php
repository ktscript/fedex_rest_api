<?php

namespace FedexRest\Entity;

class Address
{
    public array $street_lines;
    public string $city;
    public string $state_or_province;
    public string $postal_code;
    public string $country_code;

    /**
     * @param $street_lines
     * @return $this
     */
    public function setStreetLines(...$street_lines)
    {
        $this->street_lines = $street_lines;
        return $this;
    }

    /**
     * @param  string  $city
     * @return $this
     */
    public function setCity(string $city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @param  string  $state_or_province
     * @return $this
     */
    public function setStateOrProvince(string $state_or_province)
    {
        $this->state_or_province = $state_or_province;
        return $this;
    }

    /**
     * @param  int|string  $postal_code
     * @return $this
     */
    public function setPostalCode(string $postal_code)
    {
        $this->postal_code = $postal_code;
        return $this;
    }

    /**
     * @param  string  $country_code
     * @return $this
     */
    public function setCountryCode(string $country_code)
    {
        $this->country_code = $country_code;
        return $this;
    }

    public function prepare()
    {
        return [
            'streetLines' => $this->street_lines,
            'city' => $this->city,
            'stateOrProvinceCode' => $this->state_or_province,
            'postalCode' => $this->postal_code,
            'countryCode' => $this->country_code,
        ];
    }
}
