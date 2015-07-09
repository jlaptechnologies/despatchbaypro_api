<?php

namespace DespatchBayProApi\Labels;

/**
 * @author Justin Patchett <justin.patchett@thesalegroup.co.uk>
 * 
 * * WARNING: Use of the labels service will charge your DespatchBayPro account
 * * upon calling getLabels() with a valid shipmentID
 * 
 * 
 * 
 */
class LabelService
{
    
    private $labelSizes = [ [0] => ['code' => '1A6', 'description' => '1 label per A6 sheet (ideal for thermal printers)'],
                            [1] => ['code' => '1A4', 'description' => '1 label per A4 sheet (A5 landscape)'],
                            [2] => ['code' => '2A4', 'description' => '2 labels per A4 sheet (A5 landscape)'] ];
    
    /**
     *
     * @var integer
     */
    private $labelFormat;
    
    /**
     *
     * @var string 
     */
    private $connectionString;
    
    /**
     *
     * @var array 
     */
    public $apiCredentials;
    
    /**
     * 
     * @param string $labelsAddress
     * @param string $version
     * @param array $soapOptions
     * @return \DespatchBayProApi\Labels\LabelService|boolean
     */
    public function __construct($labelsAddress=null,$version='1.0.1',$soapOptions=null)
    {
        if (!$labelsAddress || !is_string($labelsAddress) || !$soapOptions || !is_array($soapOptions)) {
            return false;
        }
        $this->connectionString = $labelsAddress . $version . '/labels';
        $this->apiCredentials['apiuser'] = $soapOptions['login'];
        $this->apiCredentials['apikey']  = $soapOptions['password'];
        return $this;
    }
    
    /**
     * 
     * @param integer $labelFormat
     * @return \DespatchBayProApi\Labels\LabelService|boolean
     */
    public function setLabelFormat($labelFormat=null)
    {
        if (!$labelFormat) {
            return false;
        } else {
            $this->labelFormat = $this->labelSizes[$labelFormat];
            return $this;
        }
    }
    
    /**
     * Returns an array of available label sizes
     * 
     * @return array
     */
    public function getAvailableLabelSizes()
    {
        return $this->labelSizes;
    }
    
    /**
     * Returns a PDF file after charging your account
     * @param string $shipmentID
     * @return application/pdf
     */
    public function getLabels($shipmentID=null)
    {
        $postdata = http_build_query(
            array(
                'apiuser' => $this->apiCredentials['apiuser'],
                'apikey'  => $this->apiCredentials['apikey'],
                'format'  => $this->labelFormat,
                'sid'     => $shipmentID
            )
        );

        $opts = array(
                    'http' =>
                        array(
                            'method'  => 'POST',
                            'header'  => 'Content-type: application/x-www-form-urlencoded\r\n' .
                                         'Accept-Encoding: gzip,deflate,sdch\r\n',
                            'content' => $postdata
                        )
        );

        $context  = stream_context_create($opts);

        $result = file_get_contents($this->connectionString, false, $context);
    }
}