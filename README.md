# despatchbaypro_api
Despatch Bay Pro API Client

Provided as is.

## Usage

```php

$apiUser = 'your_api_user_string_here';
$apiKey  = 'your_api_key_here';

$dbpApiClient = new \DespatchBayProApi\DespatchBayProApiClient($apiUser,$apiKey);

// AddressingService

$dbpApiClient->addressingService->getDomesticAddressKeysByPostcode('S118RR');

$dbpApiClient->addressingService->getDomesticAddressByLookup('S118RR', 13);

$dbpApiClient->addressingService->getDomesticAddressByKey($key);

// ShippingService

$dbpApiClient->shippingService->getDomesticServicesByPostcode('S118RR');

$dbpApiClient->shippingService->getDomesticServices()

$dbpApiClient->shippingService->getShipment($shipmentID)
     
$domesticShipmentDetailsArray = [
    'ServiceID'             =>  $serviceID,
    'OrderReference'        =>  $orderReference,
    'Contents'              =>  $contents,
    'ParcelQuantity'        =>  count($parcels),
    'CompanyName'           =>  $companyName,
    'ReceiptName'           =>  $receiptName,
    'Street'                =>  $street,
    'Locality'              =>  $locality,
    'Town'                  =>  $town,
    'County'                =>  $county,
    'Postcode'              =>  $postcode,
    'RecipientEmail'        =>  $receipientEmail,
    'EmailNotification'     =>  (boolval($emailNotification))?1:0,
    'DashboardNotification' =>  (boolval($dashboardNotification))?1:0
];

$dbpApiClient->shippingService->addDomesticShipment($domesticShipmentDetailsArray);

// TrackingService

$dbpApiClient->trackingService->getTracking($trackingNumber);

// LabelsService

$labelSizes = $dbpApiClient->labelsService->getAvailableLabelSizes();

$dbpApiClient->labelsService->setLabelFormat(0);

// Warning: this function charges your account!
$dbpApiClient->labelsService->getLabels($shipmentID);

```
