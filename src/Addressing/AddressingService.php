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
        $getDomesticAddressKeysByPostcodeResult = false;
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
    
    public function getDomesticAddressByLookup($postcode=null,$property=null)
    {
        $getDomesticAddressByLookupResult = false;
        if (!$postcode || !$property || !$this->soapClient) {
            return $getDomesticAddressByLookupResult;
        }
        try {
            $getDomesticAddressByLookupResult = $this->soapClient->GetDomesticAddressByLookup($postcode,$property);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $getDomesticAddressByLookupResult;
    }
    
    public function getDomesticAddressByKey($key=null)
    {
        $getDomesticAddressByKeyResult = false;
        if (!$key) {
            return $getDomesticAddressByKeyResult;
        }
        try {
            $getDomesticAddressByKeyResult = $this->soapClient->GetDomesticAddressByKey($key);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $getDomesticAddressByKeyResult;
    }

}