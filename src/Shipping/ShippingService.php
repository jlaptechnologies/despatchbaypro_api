<?php

namespace DespatchBayProApi\Shipping;

/**
 * @author Justin Patchett <justin.patchett@thesalegroup.co.uk>
 */
class ShippingService
{
    /**
     *
     * @var SoapClient $soapClient 
     */
    public $soapClient;
    
    /**
     * 
     * @param string $wsdlAddress
     * @param array $soapOptions
     * @return \DespatchBayProApi\Shipping\ShippingService|boolean
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
     * 
     * @param string $postcode
     * @return boolean - Failure
     * @return string  - Exception Message
     * @return array   - Array of Domestic Services available to postcode
     */
    public function getDomesticServicesByPostcode($postcode=null)
    {
        $getDomesticServicesByPostcodeResult = false;
        if (!$postcode) {
            return $getDomesticServicesByPostcodeResult;
        }
        try {
            $getDomesticServicesByPostcodeResult = $this->soapClient->GetDomesticServicesByPostcode($postcode);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        return $getDomesticServicesByPostcodeResult;
    }
    
    /**
     * 
     * @return boolean - Failure
     * @return string  - Exception Message
     * @return array   - Array of all Domestic Services available
     */
    public function getDomesticServices()
    {
        $getDomesticServicesResult = false;
        try {
            $getDomesticServicesResult = $this->soapClient->GetDomesticServices();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $getDomesticServicesResult;
    }
    
    /**
     * 
     * @param string $shipmentID
     * @return boolean - Failure
     * @return string  - Exception Message
     * @return array   - Array of Domestic Services available to postcode
     */
    public function getShipment($shipmentID=null)
    {
        $getShipmentResult = false;
        if (!$shipmentID) {
            return $getShipmentResult;
        }
        try {
            $getShipmentResult = $this->soapClient->GetShipment($shipmentID);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $getShipmentResult;
    }
    
    /**
     * Adds a domestic shipment to the shipment queue
     * 
     * @param array $domesticShipmentDetailsArray
     * @return string $shipmentID
     * 
     $domesticShipmentDetailsArray should contain the following elements:
     ServiceID ( obtained by using DespatchBayProApiClient->addressingService->getDomesticServices[ByPostcode] )
     OrderReference (string )
     Contents (string )
     ParcelQuantity ( integer )
     CompanyName (string ) (optional)
     RecipientName (string )
     Street (string )
     Locality (string )
     Town (string )
     County (string )
     Postcode (string )
     RecipientEmail (string ) ( optional)
     EmailNotification (0 = false, 1 = true)
     DashboardNotification (0 = false, 1 = true)
     * 
     */
    public function addDomesticShipment($domesticShipmentDetailsArray=null)
    {
        $addDomesticShipmentResult = false;
        if (!$domesticShipmentDetailsArray) {
            return $addDomesticShipmentResult;
        }
        try {
            $shipment = new StdClass();
            foreach ($addDomesticShipmentDetailsArray as $shipmentDetailKey => $shipmentDetailValue) {
                $shipment->$shipmentDetailKey = $shipmentDetailValue;
            }
            $addDomesticShipmentResult = $this->soapClient->AddDomesticShipment($shipment);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $addDomesticShipmentResult;
    }
}