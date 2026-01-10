<?php


namespace FedexRest\Services;


/**
 * Interface for all FedEx API request classes
 * Defines the contract that all request implementations must follow
 */
interface RequestInterface
{
    /**
     * Set the OAuth access token for API requests
     *
     * @param  string  $access_token  OAuth access token
     * @return mixed  Returns instance for method chaining
     */
    public function setAccessToken(string $access_token);

    /**
     * Set the API endpoint path for the request
     *
     * @return mixed  API endpoint path string
     */
    public function setApiEndpoint();

    /**
     * Execute the API request
     *
     * @return mixed  API response (decoded JSON or raw response)
     */
    public function request();
}
