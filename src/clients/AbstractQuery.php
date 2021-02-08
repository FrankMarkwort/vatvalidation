<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation\clients;

use poseidon\vatvalidation\clients\QueryInterface;
use poseidon\vatvalidation\exceptions\ValidateVatException;
use poseidon\vatvalidation\config\Definitions;
use poseidon\vatvalidation\message\ResponseInterface;
use poseidon\vatvalidation\message\RequestInterface;

abstract class AbstractQuery
{
    protected static $SERVER_URL;   
    protected static $NAME_USTID_1 = 'UstId_1';
    protected static $NAME_ERROR_CODE = 'ErrorCode';
    protected static $NAME_USTID_2 = 'UstId_2';
    protected static $NAME_DRUCK = 'Druck';
    protected static $NAME_ERG_PLZ = 'Erg_PLZ';
    protected static $NAME_ORT = 'Ort';
    protected static $NAME_DATUM = 'Datum';
    protected static $NAME_PLZ = 'PLZ';
    protected static $NAME_ERG_ORT = 'Erg_Ort';
    protected static $NAME_UHRZEIT = 'Uhrzeit';
    protected static $NAME_ERG_NAME = 'Erg_Name';
    protected static $NAME_GUELTIG_AB =  'Gueltig_ab';
    protected static $NAME_GUELTIG_BIS = 'Gueltig_bis';
    protected static $NAME_STRASSE = 'Strasse';
    protected static $NAME_FIRMENNAME = 'Firmenname';
    protected static $NAME_ERG_STR = 'Erg_Str'; 
    protected $response;
    protected $request;
    
    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->response = $response;
        $this->request = $request;
    }
    
    public function sendRequestToService(): QueryInterface
    {
        try {
            $this->parseResultAndSetinitResponse($this->serviceCall(static::$SERVER_URL));
        } catch (ValidateVatException $e) {
            $this->setErrorCode($e->getCode());
        }
        
        return  $this;        
    }
      
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
    
    public function getResponse(): ResponseInterface
    {   
        return $this->response;
    }
    
    protected function setErrorCode(int $errorCode):self
    {
        switch ($errorCode) {
            case Definitions::ERROR_CODE_SERVICE_NOT_AVAILABLE:
                $this->initResponse(static::$NAME_ERROR_CODE, Definitions::ERROR_CODE_SERVICE_NOT_AVAILABLE);
                break;
            case Definitions::ERROR_CODE_INVALID_REQUEST_DATA:
                $this->initResponse(static::$NAME_ERROR_CODE, Definitions::ERROR_CODE_INVALID_REQUEST_DATA);
        }
        
        return $this;
    }
    /**
     * @codeCoverageIgnore
     * @throws ValidateVatException
     */
    abstract protected function serviceCall(string $url); 
    
    /**
     * 
     * @throws ValidateVatException
     */
    abstract protected function parseResultAndSetInitResponse($xmlString): void;
    
    protected function initResponse(string $name, $value): void
    {
        switch ($name) {
            case AbstractQuery::$NAME_DATUM: 
                $this->response->setDatum($value);
                break;
            case AbstractQuery::$NAME_USTID_1:
                $this->response->setUstid1($value);
                break;
            case AbstractQuery::$NAME_ERROR_CODE:
                $this->response->setErrorCode($value);
                break;
            case AbstractQuery::$NAME_USTID_2:
                $this->response->setUstId2($value);
                break;
            case AbstractQuery::$NAME_DRUCK:
                if (is_bool($value)) {
                    $this->response->setDruck($value);
                } else {
                    $boolArray = ['ja' => true, 'nein' => false];                   
                    $this->response->setDruck($boolArray[strtolower($value)]);
                }
                break;
            case AbstractQuery::$NAME_ORT:
                $this->response->setOrt($value);
                break;
            case AbstractQuery::$NAME_PLZ:
                $this->response->setPlz($value);
                break;
            case AbstractQuery::$NAME_ERG_ORT:
                $this->response->setErgOrt($value);
                break;
            case AbstractQuery::$NAME_UHRZEIT:
                $this->response->setUhrzeit($value);
                break;
            case AbstractQuery::$NAME_ERG_NAME:
                $this->response->setErgName($value);
                break;
            case AbstractQuery::$NAME_GUELTIG_AB:
                $this->response->setGueltigAb($value);
                break;
            case AbstractQuery::$NAME_GUELTIG_BIS:
                $this->response->setGueltigBis($value);
                break;
            case AbstractQuery::$NAME_STRASSE:
                $this->response->setStrasse($value);
                break;
            case AbstractQuery::$NAME_FIRMENNAME:
                $this->response->setFirmenName($value);
                break;
            case AbstractQuery::$NAME_ERG_STR:
                $this->response->setErgStr($value);
                break;
            default:                
        }
    }
}
 