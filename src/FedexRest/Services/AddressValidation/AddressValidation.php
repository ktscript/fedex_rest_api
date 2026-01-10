<?php

namespace FedexRest\Services\AddressValidation;

use FedexRest\Entity\Address;
use FedexRest\Services\AbstractRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class for validating addresses using FedEx address validation service
 */
class AddressValidation extends AbstractRequest
{
    protected ?Address $address;

    /**
     * Get the API endpoint for address validation requests
     *
     * @return string  API endpoint path
     */
    public function setApiEndpoint(): string
    {
        return '/address/v1/addresses/resolve';
    }

    /**
     * Set the address to validate
     *
     * @param  Address|null  $address  Address object to validate
     * @return AddressValidation
     */
    public function setAddress(?Address $address): AddressValidation
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Prepare address validation data for API request
     *
     * @return array  Prepared request data array
     */
    #[ArrayShape(['json' => "array"])]
    public function prepare(): array
    {
        return [
            'json' => [
                'addressesToValidate' => [
                    [
                        'address' => $this->address->prepare(),
                    ],
                ],
            ],
        ];
    }

    /**
     * Execute address validation request to FedEx API
     *
     * @return mixed  Decoded JSON response or raw response if asRaw() was called
     */
    public function request()
    {
        parent::request();
        $query = $this->http_client->post($this->getApiUri($this->api_endpoint), $this->prepare());
        return ($this->raw === true) ? $query : json_decode($query->getBody()->getContents());
    }
}
