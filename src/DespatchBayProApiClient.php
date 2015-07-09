<?php

/**
 * @author Justin Patchett <justin.patchett@thesalegroup.co.uk>
 * @file
 * Contains \DespatchBayProApi\DespatchBayProApiClient
 * 
 *
 */

namespace DespatchBayProApi;

use DespatchBayProApi\Addressing\AddressingService;
use DespatchBayProApi\Shipping\ShippingService;
use DespatchBayProApi\Tracking\TrackingService;
use DespatchBayProApi\Labels\LabelService;

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
    const WSDLENDPOINT   = 'https://api.despatchbaypro.com/api/soap/';
    const LABELSENDPOINT = 'https://api.despatchbaypro.com/pdf/';
    
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
    public $labelsService;
    
    /**
     * DespatchBayProApiClient constructor
     * 
     * @param $apiUser String
     * @param $apiKey String
     * @param $version Int
     * @return \DespatchBayProApi\DespatchBayProApiClient|boolean
     */
    public function __construct($apiUser,$apiKey,$version=11)
    {
        // Reduce the number of return paths
        $success = false;
        
        if ($apiUser !== null && $apiKey !== null) {
            try {
                // Set up global connection options using username and password.
                // Pass compression option to reduce network latency and load
                $this->soapOptions = array('login' => $apiUser, 'password' => $apiKey,
                                            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);
                                            
                $this->connection  = self::WSDLENDPOINT . 'v' . $version . '/';
                
                $this->addressingService = new AddressingService($this->connection . 'addressing?wsdl', $this->soapOptions);
                $this->shippingService   = new ShippingService($this->connection . 'shipping?wsdl', $this->soapOptions);
                $this->trackingService   = new TrackingService($this->connection . 'tracking?wsdl', $this->soapOptions);
                $this->labelsService     = new LabelService(self::LABELSENDPOINT, '1.0.1', $this->soapOptions);
                
                $success = true;
            } catch(\Exception $e) {
                return $e->getMessage();
            }
        } else {
            $success = false;
        }
        return ($success) ? $this : false;
    }
}