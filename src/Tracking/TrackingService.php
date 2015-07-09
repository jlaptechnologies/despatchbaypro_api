<?php

namespace DespatchBayProApi\Tracking;

/**
 * @author Justin Patchett <justin.patchett@thesalegroup.co.uk>
 */
class TrackingService
{
    /**
     * @var SoapClient Soap Client
     */
    public $soapClient;
    
    /**
     * Constructor for the tracking service object
     * @param string $wsdlAddress
     * @param array $soapOptions
     */
    public function __construct($wsdlAddress,$soapOptions)
    {
        if ($wsdlAddress && $soapOptions) {
            $this->soapClient = new \SoapClient($wsdlAddress,$soapOptions);
            return $this;
        } else {
            return false;
        }
    }
    
    /**
     * Gets tracking info for a tracking number
     * @param string $trackingNumber
     * @return array $getTrackingResult
     * @return string $e Exception message
     */
    public function getTracking($trackingNumber=null)
    {
        $getTrackingResult = false;
        if (!$trackingNumber) {
            return $getTrackingResult;
        }
        try {
            $getTrackingResult = $this->soapClient->GetTracking($trackingNumber);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $getTrackingResult;
    }
}