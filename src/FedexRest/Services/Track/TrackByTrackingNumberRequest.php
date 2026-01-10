<?php


namespace FedexRest\Services\Track;


use FedexRest\Exceptions\MissingTrackingNumberException;
use FedexRest\Services\AbstractRequest;
use GuzzleHttp\Client;

/**
 * Class for tracking packages by tracking number
 */
class TrackByTrackingNumberRequest extends AbstractRequest
{
    private array $tracking_number;
    private bool $include_detailed_scans = false;

    /**
     * Get the API endpoint for tracking requests
     *
     * @return string  API endpoint path
     */
    public function setApiEndpoint()
    {
        return '/track/v1/trackingnumbers';
    }

    /**
     * Set tracking number(s) to track
     * Can accept a single tracking number or an array of tracking numbers
     *
     * @param string|array $tracking_number  Tracking number(s)
     * @return $this
     */
    public function setTrackingNumber($tracking_number)
    {
        $this->tracking_number = (array) $tracking_number;
        return $this;
    }

    /**
     * Execute tracking request to FedEx API
     *
     * @return mixed  Decoded JSON response or raw response if asRaw() was called
     * @throws MissingTrackingNumberException  When tracking number is not set
     */
    public function request()
    {
        parent::request();

        if (empty($this->tracking_number)) {
            throw new MissingTrackingNumberException('Please enter at least one tracking number');
        }

        try {
            $query = $this->http_client->post($this->getApiUri($this->api_endpoint), [
                'json' => [
                    'includeDetailedScans' => $this->include_detailed_scans,
                    'trackingInfo' => $this->preparedData(),
                ]
            ]);
            return ($this->raw === true) ? $query : json_decode($query->getBody()->getContents());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Prepare tracking data for API request
     *
     * @return array  Formatted tracking data array
     */
    private function preparedData()
    {
        $data = [];
        foreach ($this->tracking_number as $token) {
            array_push($data, [
                'trackingNumberInfo' =>
                    [
                        'trackingNumber' => $token,
                    ],
            ]);
        }

        return $data;
    }

    /**
     * Include detailed scan information in the tracking response
     *
     * @return $this
     */
    public function includeDetailedScans()
    {
        $this->include_detailed_scans = true;
        return $this;
    }
}
