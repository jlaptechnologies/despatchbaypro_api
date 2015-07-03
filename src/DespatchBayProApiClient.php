<?php

/**
 * @author Justin Patchett <justin.patchett@thesalegroup.co.uk>
 * @file
 * Contains \DespatchBayProAPI\DespatchBayProClient
 * 
 *
 */

namespace DespatchBayProApi;

use DespatchBayProApi\Addressing\AddressingService;
use DespatchBayProApi\Shipping\ShippingService;
use DespatchBayProApi\Tracking\TrackingService;

/**
 * Interacts with a DespatchBayProAPI instance.
 *
 *
 */

class DespatchBayProApiClient
{
    /**
     * The WSDL endpoint
     */
    const WSDLENDPOINT = 'https://api.despatchbaypro.com/api/soap/';
    
    /**
     * The eventual connection
     * @var DespatchBayProApiClient
     */
    public $connection;
    
    /**
     * Hold the SOAP options seperately
     *
     * @var array
     */
    public $soapOptions;
    
    /**
     * Hold the various connection objects
     *
     * @var addressingService
     * @var shippingService
     * @var trackingService
     */
    public $addressingService;
    public $shippingService;
    public $trackingService;
    
    /**
     * DespatchBayProApiClient constructor
     * 
     * @param $apiUser String
     * @param $apiKey String
     * @param $version Int
     */
    public function __construct($apiUser,$apiKey,$version=11)
    {
        // Reduce the number of return paths
        $success = false;
        
        if ($apiUser !== null && $apiKey !== null) {
            
            $this->soapOptions = array('login' => $apiUser, 'password' => $apiKey,
                                        'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);
                                        
            $this->connection  = WSDLENDPOINT . 'v' . $version . '/';
            
            $this->addressingService = new AddressingService($this->connection . 'addressing?wsdl', $this->soapOptions);
            $this->shippingService   = new ShippingService($this->connection . 'shipping?wsdl', $this->soapOptions);
            $this->trackingService   = new TrackingService($this->connection . 'tracking?wsdl', $this->soapOptions);
            
            $success = true;
        } else {
            $success = false;
        }
        return ($success) ? $this : false;
    }
}