<?php

namespace DespatchBayProApi\Shipping;

class ShippingService
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
    
    public function getDomesticServicesByPostcode($postcode=null)
    {
        $getDomesticServicesByPostcodeResult = false;
        if (!$postcode) {
            return $getDomesticServicesByPostcodeResult;
        }
        try {
            $getDomesticServicesByPostcodeResult = $this->soapClient->GetDomesticServicesByPostcode($postcode);
        } catch(Exception $e) {
            return $e->getMessage();
        }
        return $getDomesticServicesByPostcodeResult;
    }
    
    public function getDomesticServices()
    {
        $getDomesticServicesResult = false;
        try {
            $getDomesticServicesResult = $this->soapClient->GetDomesticServices();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $getDomesticServicesResult;
    }
    
    public function getShipment($shipmentID=null)
    {
        $getShipmentResult = false;
        if (!$shipmentID) {
            return $getShipmentResult;
        }
        try {
            $getShipmentResult = $this->soapClient->GetShipment($shipmentID);
        } catch (Exception $e) {
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
     ServiceID
     OrderReference
     Contents
     ParcelQuantity
     CompanyName
     RecipientName
     Street
     Locality
     Town
     County
     Postcode
     RecipientEmail
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
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $addDomesticShipmentResult;
    }
}