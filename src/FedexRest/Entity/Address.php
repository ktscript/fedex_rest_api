<?php

namespace FedexRest\Entity;

/**
 * Address entity class for storing address information
 */
class Address
{
    public array $street_lines;
    public string $city;
    public string $state_or_province;
    public string $postal_code;
    public string $country_code;

    /**
     * Set street address lines
     * Can accept multiple street lines as variadic arguments
     *
     * @param string ...$street_lines  Street address lines
     * @return $this
     */
    public function setStreetLines(...$street_lines)
    {
        $this->street_lines = $street_lines;
        return $this;
    }

    /**
     * Set the city name
     *
     * @param  string  $city  City name
     * @return $this
     */
    public function setCity(string $city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Set the state or province code
     *
     * @param  string  $state_or_province  State or province code
     * @return $this
     */
    public function setStateOrProvince(string $state_or_province)
    {
        $this->state_or_province = $state_or_province;
        return $this;
    }

    /**
     * Set the postal/ZIP code
     *
     * @param  string  $postal_code  Postal or ZIP code
     * @return $this
     */
    public function setPostalCode(string $postal_code)
    {
        $this->postal_code = $postal_code;
        return $this;
    }

    /**
     * Set the country code (ISO 2-letter code)
     *
     * @param  string  $country_code  Two-letter country code (e.g., 'US', 'CA')
     * @return $this
     */
    public function setCountryCode(string $country_code)
    {
        $this->country_code = $country_code;
        return $this;
    }

    /**
     * Prepare address data for API request
     *
     * @return array  Formatted address array for FedEx API
     */
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
