<?php

namespace FedexRest\Traits;

use Illuminate\Support\Traits\Conditionable;

/**
 * Trait for switching between sandbox and production environments
 * Uses Laravel's Conditionable trait for conditional method chaining
 */
trait switchableEnv
{
    use Conditionable;

    public bool $production_mode = false;
    protected string $production_url = 'https://apis.fedex.com';
    protected string $testing_url = 'https://apis-sandbox.fedex.com';

    /**
     * Get the full API URI based on current environment (sandbox or production)
     *
     * @param string $endpoint  API endpoint path to append
     * @return string  Full API URL
     */
    public function getApiUri($endpoint = '')
    {
        return (($this->production_mode === false) ? $this->testing_url : $this->production_url).$endpoint;
    }

    /**
     * Switch to production environment
     * By default, requests use sandbox (testing) environment
     *
     * @return $this
     */
    public function useProduction()
    {
        $this->production_mode = true;
        return $this;
    }
}
