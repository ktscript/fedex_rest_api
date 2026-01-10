<?php


namespace FedexRest\Authorization;


use FedexRest\Exceptions\MissingAuthCredentialsException;
use FedexRest\Traits\rawable;
use FedexRest\Traits\switchableEnv;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class for handling FedEx OAuth 2.0 authorization
 */
class Authorize
{
    use switchableEnv, rawable;

    private string $client_id;
    private string $client_secret;

    /**
     * Set the client ID for OAuth authorization
     *
     * @param  string  $client_id  FedEx API client ID
     * @return Authorize
     */
    public function setClientId(string $client_id): Authorize
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * Set the client secret for OAuth authorization
     *
     * @param  string  $client_secret  FedEx API client secret
     * @return Authorize
     */
    public function setClientSecret(string $client_secret): Authorize
    {
        $this->client_secret = $client_secret;
        return $this;
    }

    /**
     * Authorize and obtain access token from FedEx API
     *
     * @return mixed|string  Access token object or error message
     * @throws MissingAuthCredentialsException  When client ID or secret is not provided
     * @throws GuzzleException  When HTTP request fails
     */
    public function authorize()
    {
        $httpClient = new Client();
        if (isset($this->client_id) && isset($this->client_secret)) {
            try {
                $query = $httpClient->request('POST', $this->getApiUri('/oauth/token'), [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => $this->client_id,
                        'client_secret' => $this->client_secret,
                    ]
                ]);
                if ($query->getStatusCode() === 200) {
                    return ($this->raw === true) ? $query : json_decode($query->getBody()->getContents());
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new MissingAuthCredentialsException('Please provide auth credentials');
        }
    }
}
