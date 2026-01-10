<?php


namespace FedexRest\Services;


use FedexRest\Exceptions\MissingAccessTokenException;
use FedexRest\Traits\rawable;
use FedexRest\Traits\switchableEnv;
use GuzzleHttp\Client;


/**
 * Abstract base class for all FedEx API requests
 */
abstract class AbstractRequest implements RequestInterface
{
    use switchableEnv, rawable;

    public string $api_endpoint = '';
    protected string $access_token;
    protected Client $http_client;

    /**
     * AbstractRequest constructor.
     * Initializes the API endpoint by calling setApiEndpoint()
     */
    public function __construct()
    {
        $this->api_endpoint = $this->setApiEndpoint();
    }

    /**
     * Set the OAuth access token for API requests
     *
     * @param  string  $access_token  OAuth access token
     * @return $this|mixed
     */
    public function setAccessToken(string $access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * Set the client ID for authentication
     *
     * @param mixed $clientId  FedEx API client ID
     * @return $this
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * Set the client secret for authentication
     *
     * @param mixed $client_secret  FedEx API client secret
     * @return $this|string
     */
    public function setClientSecret($client_secret)
    {
        $this->clientSecret = $client_secret;
        return $this;
    }

    /**
     * Initialize HTTP client with authorization headers
     * Must be called before making API requests
     *
     * @throws MissingAccessTokenException  When access token is not set
     */
    public function request()
    {
        if (empty($this->access_token)) {
            throw new MissingAccessTokenException('Authorization token is missing. Make sure it is included');
        }
        $this->http_client = new Client([
            'headers' => [
                'Authorization' => "Bearer {$this->access_token}",
                'Content-Type' => 'application/json'
            ],
        ]);
    }
}
