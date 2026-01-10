<?php

namespace FedexRest\Services\Ship;

use FedexRest\Entity\Item;
use FedexRest\Entity\Person;
use FedexRest\Exceptions\MissingAccountNumberException;
use FedexRest\Exceptions\MissingLineItemException;
use FedexRest\Services\AbstractRequest;
use FedexRest\Services\Ship\Type\ServiceType;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class for creating shipping labels (tags) for packages
 */
class CreateTagRequest extends AbstractRequest
{
    protected int $account_number;
    protected Person $shipper;
    protected array $recipients;
    protected ?Item $line_items;
    protected string $service_type;
    protected string $packaging_type;
    protected string $pickup_type;
    protected string $ship_datestamp = '';
    protected array $params;

    public function __construct()
    {
        $this->params = [
            'json' => [
                'labelResponseOptions' => 'LABEL',
                'requestedShipment' => [
                    'shipper' => null, 
                    'recipients' => null, 
                    'shipDatestamp' => null, 
                    'serviceType' => null, 
                    'packagingType' => null, 
                    'pickupType' => null, 
                    'blockInsightVisibility' => false,
                    'shippingChargesPayment' => [
                        'paymentType' => 'SENDER',
                    ],
                    'shipmentSpecialServices' => [
                        'specialServiceTypes' => [
                            'RETURN_SHIPMENT',
                        ],
                        'returnShipmentDetail' => [
                            'returnType' => 'PRINT_RETURN_LABEL',
                        ],
                    ],
                    'labelSpecification' => [
                        'imageType' => 'PDF',
                        'labelStockType' => 'PAPER_85X11_TOP_HALF_LABEL',
                    ],
                    'requestedPackageLineItems' => null, 
                ],
                'accountNumber' => [
                    'value' => null, 
                ],
            ],
        ];
    }

    /**
     * Get current request parameters
     *
     * @return array  Current request parameters
     */
    public function getRequestParams(): array
    {
        return $this->params;
    }

    /**
     * Set custom request parameters
     *
     * @param array $new_params  New request parameters array
     * @return CreateTagRequest
     */
    public function setRequestParams(array $new_params): CreateTagRequest
    {
        $this->params = $new_params;
	    return $this;
    }

    /**
     * Get the API endpoint for shipping requests
     *
     * @return string  API endpoint path
     */
    public function setApiEndpoint(): string
    {
        return '/ship/v1/shipments';
    }

    /**
     * Get the pickup type
     *
     * @return string  Current pickup type
     */
    public function getPickupType(): string
    {
        return $this->pickup_type;
    }

    /**
     * Set the pickup type for the shipment
     *
     * @param  string  $pickup_type  Pickup type constant from PickupType class
     * @return CreateTagRequest
     */
    public function setPickupType(string $pickup_type): CreateTagRequest
    {
        $this->pickup_type = $pickup_type;
        return $this;
    }

    /**
     * Get the packaging type
     *
     * @return string  Current packaging type
     */
    public function getPackagingType(): string
    {
        return $this->packaging_type;
    }

    /**
     * Set the packaging type for the shipment
     *
     * @param  string  $packaging_type  Packaging type constant from PackagingType class
     * @return CreateTagRequest
     */
    public function setPackagingType(string $packaging_type): CreateTagRequest
    {
        $this->packaging_type = $packaging_type;
        return $this;
    }

    /**
     * Get the line items for the shipment
     *
     * @return Item  Current line items
     */
    public function getLineItems(): Item
    {
        return $this->line_items;
    }

    /**
     * Set the line items (package contents) for the shipment
     *
     * @param  Item  $line_items  Item object with description and weight
     * @return CreateTagRequest
     */
    public function setLineItems(Item $line_items): CreateTagRequest
    {
        $this->line_items = $line_items;
        return $this;
    }

    /**
     * Set the ship date for the shipment
     *
     * @param  string  $ship_datestamp  Ship date in YYYY-MM-DD format
     * @return CreateTagRequest
     */
    public function setShipDatestamp(string $ship_datestamp): CreateTagRequest
    {
        $this->ship_datestamp = $ship_datestamp;
        return $this;
    }

    /**
     * Set the service type for the shipment
     *
     * @param  string  $service_type  Service type constant from ServiceType class
     * @return CreateTagRequest
     */
    public function setServiceType(string $service_type): CreateTagRequest
    {
        $this->service_type = $service_type;
        return $this;
    }

    /**
     * Get the service type
     *
     * @return string  Current service type
     */
    public function getServiceType(): string
    {
        return $this->service_type;
    }

    /**
     * Get the recipients array
     *
     * @return array  Array of Person objects (recipients)
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * Get the shipper
     *
     * @return Person  Shipper Person object
     */
    public function getShipper(): Person
    {
        return $this->shipper;
    }

    /**
     * Set the shipper (sender) information
     *
     * @param  Person  $shipper  Person object with shipper details and address
     * @return CreateTagRequest
     */
    public function setShipper(Person $shipper): CreateTagRequest
    {
        $this->shipper = $shipper;
        return $this;
    }

    /**
     * Set the recipients for the shipment
     * Can accept multiple Person objects as variadic arguments
     *
     * @param  Person  ...$recipients  One or more Person objects (recipients)
     * @return CreateTagRequest
     */
    public function setRecipients(Person ...$recipients): CreateTagRequest
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * Set the FedEx account number
     *
     * @param  int  $account_number  FedEx account number
     * @return CreateTagRequest
     */
    public function setAccountNumber(int $account_number): CreateTagRequest
    {
        $this->account_number = $account_number;
        return $this;
    }

    /**
     * Prepare request data for API call
     *
     * @return array  Prepared request data array
     */
    #[ArrayShape(['json' => "array"])]
    public function prepare(): array
    {
    }

    /**
     * Execute shipping label creation request to FedEx API
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface  API response
     * @throws MissingAccountNumberException  When account number is not set
     * @throws MissingLineItemException  When line items are not set
     * @throws \FedexRest\Exceptions\MissingAccessTokenException  When access token is not set
     */
    public function request()
    {
        parent::request();
        return $this->http_client->post($this->getApiUri($this->setApiEndpoint()), $this->params);
    }

}
