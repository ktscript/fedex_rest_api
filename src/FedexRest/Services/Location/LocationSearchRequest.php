<?php

namespace FedexRest\Services\Location;

use FedexRest\Entity\Address;
use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Services\AbstractRequest;

/**
 * FedEx Location Search API – search for pickup/dropoff locations by address, coordinates, or phone.
 * @see https://developer.fedex.com/api/en-us/catalog/locations/v1/docs.html
 */
class LocationSearchRequest extends AbstractRequest
{
    public const CRITERION_ADDRESS = 'ADDRESS';
    public const CRITERION_GEO_COORDINATES = 'GEO_COORDINATES';
    public const CRITERION_PHONE_NUMBER = 'PHONE_NUMBER';

    public const UNITS_KM = 'KM';
    public const UNITS_MI = 'MI';

    /** @var string */
    protected $locationsSearchCriterion = self::CRITERION_ADDRESS;

    /** @var Address|null */
    protected $address;

    /** @var float|null */
    protected $latitude;

    /** @var float|null */
    protected $longitude;

    /** @var string|null */
    protected $phoneNumber;

    /** @var int|null */
    protected $distanceValue;

    /** @var string */
    protected $distanceUnits = self::UNITS_KM;

    /** @var string[] */
    protected $locationTypes = [];

    /** @var int */
    protected $resultsLimit = 25;

    /**
     * API endpoint for Location Search.
     * FedEx Location Search API: POST https://apis.fedex.com/locations/v1/locations
     */
    public function setApiEndpoint(): string
    {
        return '/locations/v1/locations';
    }

    /**
     * Search by address (uses existing Address entity).
     */
    public function setAddress(?Address $address): self
    {
        $this->address = $address;
        $this->locationsSearchCriterion = self::CRITERION_ADDRESS;
        return $this;
    }

    /**
     * Search by geographic coordinates.
     */
    public function setCoordinates(float $latitude, float $longitude): self
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->locationsSearchCriterion = self::CRITERION_GEO_COORDINATES;
        return $this;
    }

    /**
     * Search by phone number.
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        $this->locationsSearchCriterion = self::CRITERION_PHONE_NUMBER;
        return $this;
    }

    /**
     * Set search radius (distance from address/coordinates).
     */
    public function setDistance(int $value, string $units = self::UNITS_KM): self
    {
        $this->distanceValue = $value;
        $this->distanceUnits = $units;
        return $this;
    }

    /**
     * Restrict by location types (e.g. FEDEX_OFFICE, FEDEX_AUTHORIZED_SHIP_CENTER).
     */
    public function setLocationTypes(array $types): self
    {
        $this->locationTypes = $types;
        return $this;
    }

    /**
     * Maximum number of locations to return (default 25).
     */
    public function setResultsLimit(int $limit): self
    {
        $this->resultsLimit = $limit;
        return $this;
    }

    /**
     * Build request body for Location Search API.
     */
    public function prepare(): array
    {
        $body = [
            'locationsSearchCriterion' => $this->locationsSearchCriterion,
            'multipleMatchesAction' => 'RETURN_ALL',
            'sortBy' => 'DISTANCE',
            'resultsToReturn' => $this->resultsLimit,
        ];

        if ($this->locationsSearchCriterion === self::CRITERION_ADDRESS && $this->address !== null) {
            $body['address'] = $this->address->prepare();
        }

        if ($this->locationsSearchCriterion === self::CRITERION_GEO_COORDINATES
            && $this->latitude !== null
            && $this->longitude !== null
        ) {
            $body['latitude'] = $this->latitude;
            $body['longitude'] = $this->longitude;
        }

        if ($this->locationsSearchCriterion === self::CRITERION_PHONE_NUMBER && $this->phoneNumber !== null) {
            $body['phoneNumber'] = $this->phoneNumber;
        }

        if ($this->distanceValue !== null) {
            $body['distance'] = [
                'value' => $this->distanceValue,
                'units' => $this->distanceUnits,
            ];
        }

        if ($this->locationTypes !== []) {
            $body['locationTypes'] = $this->locationTypes;
        }

        return [
            'json' => $body,
        ];
    }

    /**
     * Execute Location Search request.
     *
     * @return \stdClass|object|string Raw response body decoded as object, or raw response if asRaw() was used
     * @throws MissingAccessTokenException
     */
    public function request()
    {
        parent::request();
        $response = $this->http_client->post(
            $this->getApiUri($this->api_endpoint),
            $this->prepare()
        );
        return $this->raw === true
            ? $response
            : json_decode($response->getBody()->getContents());
    }
}
