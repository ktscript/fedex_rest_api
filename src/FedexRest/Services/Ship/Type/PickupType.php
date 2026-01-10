<?php


namespace FedexRest\Services\Ship\Type;

/**
 * Pickup type constants for FedEx shipments
 * Defines how packages will be picked up from the shipper
 * @package FedexRest\Services\Ship\Type
 */
class PickupType
{
    const _CONTACT_FEDEX_TO_SCHEDULE = 'CONTACT_FEDEX_TO_SCHEDULE';
    const _DROPOFF_AT_FEDEX_LOCATION = 'DROPOFF_AT_FEDEX_LOCATION';
    const _USE_SCHEDULED_PICKUP = 'USE_SCHEDULED_PICKUP';
}
