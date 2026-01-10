<?php


namespace FedexRest;


/**
 * Utility class with helper methods
 */
class Utils
{
    /**
     * Convert an object to an array
     * Uses JSON encoding/decoding to convert object properties to array
     *
     * @param mixed $object  Object to convert
     * @return array  Converted array
     */
    public function toArray($object)
    {
        return json_decode(json_encode($object), true);
    }
}
