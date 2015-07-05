<?php

namespace DespatchBayProApi\Tracking;

class TrackingService
{
    public $soapClient;
    
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
     */
    public function getTracking($trackingNumber=null)
    {
        $getTrackingResult = false;
        if (!$trackingNumber) {
            return $getTrackingResult;
        }
        try {
            $getTrackingResult = $this->soapClient->GetTracking($trackingNumber);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $getTrackingResult;
    }
}