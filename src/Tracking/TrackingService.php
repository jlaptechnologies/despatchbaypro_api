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
}