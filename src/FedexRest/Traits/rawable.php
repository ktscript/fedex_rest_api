<?php


namespace FedexRest\Traits;


/**
 * Trait for returning raw HTTP response instead of decoded JSON
 */
trait rawable
{
    public $raw = false;

    /**
     * Enable raw response mode
     * When enabled, returns GuzzleHttp\Psr7\Response object instead of decoded JSON
     *
     * @return $this
     */
    public function asRaw()
    {
        $this->raw = true;
        return $this;
    }
}
