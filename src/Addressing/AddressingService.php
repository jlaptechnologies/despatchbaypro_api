<?php

namespace DespatchBayProApi\Addressing;

/**
 * @author Justin Patchett <justin.patchett@thesalegroup.co.uk>
 */
class AddressingService
{
    /**
     * Stores the soapClient object after a successful connection is made
     * @var \SoapClient
     */
    public $soapClient = null;
    
    /**
     * Constructs the AddressingService object
     * 
     * @param string $wsdlAddress
     * @param array $soapOptions
     * @return boolean|\DespatchBayProApi\Addressing\AddressingService
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
     * Get an array of domestic address keys when passed a valid postcode
     * 
     * @param  string $postcode
     * @return boolean
     * @return string $e - Exception message
     * @return array $getDomesticAddressKeysByPostcode - array of domestic address keys
     */
    public function getDomesticAddressKeysByPostcode($postcode=null)
    {
        $getDomesticAddressKeysByPostcodeResult = false;
        if (!$this->soapClient || !$postcode) {
            return false;
        } else {
            try {
                $getDomesticAddressKeysByPostcodeResult = $this->soapClient->GetDomesticAddressKeysByPostcode($postcode);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        return $getDomesticAddressKeysByPostcodeResult;
    }
    
    /**
     * Get a domestic address details when passed a valid postcode and property
     * 
     * @param string $postcode
     * @param string $property
     * @return boolean
     * @return array
     */
    public function getDomesticAddressByLookup($postcode=null,$property=null)
    {
        $getDomesticAddressByLookupResult = false;
        if (!$postcode || !$property || !$this->soapClient) {
            return $getDomesticAddressByLookupResult;
        }
        try {
            $getDomesticAddressByLookupResult = $this->soapClient->GetDomesticAddressByLookup($postcode,$property);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $getDomesticAddressByLookupResult;
    }
    
    /**
     * When passed a domestic address key, will return domestic address details
     * 
     * @param string $key XXXXXX[X]NNNN
     * @return boolean
     * @return array Address Details
     */
    public function getDomesticAddressByKey($key=null)
    {
        $getDomesticAddressByKeyResult = false;
        if (!$key) {
            return $getDomesticAddressByKeyResult;
        }
        try {
            $getDomesticAddressByKeyResult = $this->soapClient->GetDomesticAddressByKey($key);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $getDomesticAddressByKeyResult;
    }

}