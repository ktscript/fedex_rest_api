<?php

namespace FedexRest\Services\Location\Type;

/**
 * Location type constants for FedEx Location Search API.
 * Use with LocationSearchRequest::setLocationTypes().
 * @see https://developer.fedex.com/api/en-us/catalog/locations/v1/docs.html
 */
class LocationType
{
    /** FedEx Authorized ShipCenter */
    public const FEDEX_AUTHORIZED_SHIP_CENTER = 'FEDEX_AUTHORIZED_SHIP_CENTER';

    /** FedEx ShipCenter */
    public const FEDEX_SHIP_CENTER = 'FEDEX_SHIP_CENTER';

    /** FedEx Express Station */
    public const EXPRESS_STATION = 'EXPRESS_STATION';

    /** FedEx Office (Print and Ship) */
    public const FEDEX_OFFICE = 'FEDEX_OFFICE';

    /** FedEx self-service Drop Box */
    public const FEDEX_DROP_BOX = 'FEDEX_DROP_BOX';

    /** FedEx OnSite */
    public const FEDEX_ONSITE = 'FEDEX_ONSITE';

    /** Hold at Location */
    public const HOLD_AT_LOCATION = 'HOLD_AT_LOCATION';
}
