<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 * @example 
 * $query = new CurlQuery(new Request(), new Response()); 
 * $query->getRequest()
 *     ->setDruck(false)
 *     ->setFirmenname('Ver d.o.o.')
 *     ->setOrt('Velika Gorica')
 *     ->setPlz('10410')
 *     ->setStrasse('Mate Lovraka 1')
 *     ->setUst1('DE263721827')
 *     ->setUst2('HR20543250589');
 * $response = $query->sendRequestToService()->getResponse();     
 * $response->getErrorCode();
 * $response->isValidUstId()
 */
namespace poseidon\vatvalidation\clients;

use poseidon\vatvalidation\exceptions\ValidateVatException;
use poseidon\vatvalidation\config\Definitions;

class CurlQuery extends AbstractQuery implements QueryInterface
{
    protected static $SERVER_URL = 'https://evatr.bff-online.de/evatrRPC?';
    
    protected static $PARAM = 'param';
    protected static $VALUE = 'value';
    protected static $ARRAY = 'array';
    protected static $DATA = 'data';
    protected static $STRING = 'string';
    
    protected $firstField = true;
           
    /**
     * @codeCoverageIgnore
     */
    protected function serviceCall($url) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . $this->getRequestUrl());
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $result = curl_exec($ch);
        curl_close($ch);
        
        if (defined('PHPUNIT_DEVELOP')) {
            file_put_contents('resultCurlTest.xml', $result);
        }
        
        return $result;
    }
    
    /**
     * 
     * @throws ValidateVatException
     */
    protected function parseResultAndSetInitResponse($xmlString): void
    {
        $array = $this->resultToArray($xmlString); 
        foreach ($array[static::$PARAM] as $value) {
            $value = $value[static::$VALUE][static::$ARRAY][static::$DATA][static::$VALUE];
            if (isset($value[0][static::$STRING]) && 
                isset($value[1][static::$STRING])
                ) {
                $this->initResponse(
                    $value[0][static::$STRING],
                    empty($value[1][static::$STRING])
                    ? null
                    : $value[1][static::$STRING]
               );
            }
        }
    }
    
    /**
     * @param mixed $curlResult
     * @throws ValidateVatException
     */
    protected function resultToArray($curlResult): array
    {
        if ($curlResult === false) {
            
            throw new ValidateVatException('Curl: Service not available', Definitions::ERROR_CODE_SERVICE_NOT_AVAILABLE);
        }
        
        $array = json_decode(json_encode(simplexml_load_string($curlResult)), true) ;
        if (! is_array($array)) {
            
            throw new ValidateVatException('responce is not valid', Definitions::ERROR_CODE_INVALID_REQUEST_DATA);
        }
        
        return $array;
    }
    
    protected function getEncodedUst1(): string
    {
        if (!empty($this->getRequest()->getUst1())) {
            
            return static::$NAME_USTID_1 . '=' . $this->getRequest()->getUst1();
        }
        
        return '';
    }
    
    protected function getEncodedUst2(): string
    {
        if (!empty($this->getRequest()->getUst2())) {
            
            return static::$NAME_USTID_2 . '=' . $this->getRequest()->getUst2();
        }
        
        return '';
    }
    
    protected function getEncodedFirmenName(): string
    {
        if (!empty($this->getRequest()->getFirmenName())) {
            
            return static::$NAME_FIRMENNAME . '=' . urlencode($this->getRequest()->getFirmenName());
        }
        
        return '';
    }
    
    protected function getEncodedOrt(): string
    {
        if (!empty($this->getRequest()->getOrt())) {
            
            return static::$NAME_ORT . '=' . urlencode($this->getRequest()->getOrt());
        }
        
        return '';
    }
    
    protected function getEncodedPlz(): string
    {
        if (!empty($this->getRequest()->getPlz())) {
            
            return static::$NAME_PLZ . '=' . urlencode($this->getRequest()->getPlz());
        }
        
        return '';
    }
    
    protected function getEncodedStrasse(): string
    {
        if (!empty($this->getRequest()->getStrasse())) {
            
            return static::$NAME_STRASSE . '=' . urlencode($this->getRequest()->getStrasse());
        }
        
        return '';
    }
    
    protected function getEncodedDruck(): string
    {
        return static::$NAME_DRUCK . '=' . ($this->getRequest()->getDruck()? 'ja': 'nein');
    }
    
    protected function addFieldToURL($field):string
    {
        if (empty($field)) {
            
            return '';
        }
        
        if ($this->firstField) {
            $this->firstField = false;
            
            return $field;
        }
        
        return '&'. $field;
    }
    
    protected function getRequestUrl(): string
    {
        $http = $this->addFieldToURL($this->getEncodedUst1())
        . $this->addFieldToURL($this->getEncodedUst2())
        . $this->addFieldToURL($this->getEncodedFirmenName())
        . $this->addFieldToURL($this->getEncodedOrt())
        . $this->addFieldToURL($this->getEncodedPlz())
        . $this->addFieldToURL($this->getEncodedStrasse())
        . $this->addFieldToURL($this->getEncodedDruck());
        
        $this->firstField = true;
        
        return $http;
    }
}
 