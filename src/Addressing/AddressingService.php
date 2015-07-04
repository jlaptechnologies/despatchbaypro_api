<?php

namespace DespatchBayProApi\Addressing;

class AddressingService
{
    /**
     * Stores the soapClient object after a successful connection is made
     * @var \SoapClient
     */
    public $soapClient = null;
    
    public function __construct($wsdlAddress,$soapOptions)
    {
        if ($wsdlAddress && $soapOptions) {
            $this->soapClient = new \SoapClient($wsdlAddress,$soapOptions);
            return $this;
        } else {
            return false;
        }
    }
    
    public function getDomesticAddressKeysByPostcode($postcode=null)
    {
        $getDomesticAddressKeysByPostcodeResult = null;
        if (!$this->soapClient || !$postcode) {
            return false;
        } else {
            try {
                $getDomesticAddressKeysByPostcodeResult = $this->soapClient->GetDomesticAddressKeysByPostcode($postcode);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $getDomesticAddressKeysByPostcodeResult;
    }
    
    public function 

}