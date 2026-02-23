<?php

namespace FedexRest\Services\Location\Type;

/**
 * Location type constants for FedEx Location Search API (request body locationTypes enum).
 * Use with LocationSearchRequest::setLocationTypes().
 * @see https://developer.fedex.com/api/en-us/catalog/locations/v1/docs.html
 */
class LocationType
{
    public const FEDEX_AUTHORIZED_SHIP_CENTER = 'FEDEX_AUTHORIZED_SHIP_CENTER';
    public const FEDEX_OFFICE = 'FEDEX_OFFICE';
    /** FedEx self-service / Drop Box */
    public const FEDEX_SELF_SERVICE_LOCATION = 'FEDEX_SELF_SERVICE_LOCATION';
    public const FEDEX_ONSITE = 'FEDEX_ONSITE';
    public const FEDEX_EXPRESS_STATION = 'FEDEX_EXPRESS_STATION';
    public const FEDEX_SHIPSITE = 'FEDEX_SHIPSITE';
    public const FEDEX_SHIP_AND_GET = 'FEDEX_SHIP_AND_GET';
}
