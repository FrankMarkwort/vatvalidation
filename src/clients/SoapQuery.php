<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 * @example 
 * $query = new SoapQuery(new Request(), new Response()); 
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
use \SoapClient;
use \SoapFault;
use \Exception;
use \DateTime;

class SoapQuery extends AbstractQuery implements QueryInterface
{
    protected static $SERVER_URL = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';
    
    protected static $PARAM = 'param';
    protected static $VALUE = 'value';
    protected static $ARRAY = 'array';
    protected static $DATA = 'data';
    protected static $STRING = 'string';
    /**
     * 
     * @var DateTime
     */
    protected $dateTime;
           
    /**
     * @codeCoverageIgnore
     * @throws ValidateVatException
     */
    protected function serviceCall($wdsl) 
    {       
        try{
            $soapClient = new SoapClient($wdsl, $this->getSoapOptions());
           
            $result = $soapClient->checkVatApprox($this->getSoapRequestRequestParameter());
            
            if (defined('PHPUNIT_DEVELOP')) {
                
                file_put_contents('resultTest.txt', serialize($result));
            }
            
            return $result;
            
        } catch(SoapFault $e) {
            #trigger_error('SOAP-Fehler: (Fehlernummer: '. $e->faultcode .', Fehlermeldung: '. $e->faultstring .')', E_USER_ERROR);
           
            throw new ValidateVatException($e->faultstring, Definitions::ERROR_CODE_SERVICE_NOT_AVAILABLE);
        } catch (Exception $e) {
            
            throw new ValidateVatException('soap call error', Definitions::ERROR_CODE_INVALID_REQUEST_DATA);
        }
    }
    
    protected function parseResultAndSetInitResponse($stdObj): void
    {      
        $errorCode = [
            true  => Definitions::ERROR_CODE_IS_VALID,
            false => Definitions::ERROR_CODE_IS_NOT_VALID,
        ];
        $this->initResponse(static::$NAME_USTID_2, $stdObj->countryCode.$stdObj->vatNumber);
        $this->initResponse(static::$NAME_FIRMENNAME, $stdObj->traderName);
        $this->initResponse(static::$NAME_ERROR_CODE, $errorCode[$stdObj->valid]);
        $this->setDateTime($stdObj->requestDate);
        $this->initResponse(static::$NAME_DATUM, $this->getDate());
        $this->initResponse(static::$NAME_UHRZEIT, $this->getTime());
        $this->initResponse(static::$NAME_DRUCK, false);
    }  
    
    protected function getDate():?string
    {
        if($this->dateTime instanceof DateTime) {
            
            return $this->dateTime->format('d-m-Y');
        }
        
        return null;
    }
    
    protected function getTime():?string
    {
        if($this->dateTime instanceof DateTime) {
            
            return $this->dateTime->format('H:i:s');
        }
        
        return null;
    }
    
    protected function setDateTime(string $string):self
    {
        if (strlen($string) === 16) {
            $this->dateTime = new DateTime($string);
        }
        
        return $this;
    }
    
    /**
    * @codeCoverageIgnore
    */
    protected function getSoapOptions():array
    {
        return [
            'soap_version' => SOAP_1_1,
            'exceptions' => true,
            'trace' => 1,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'user_agent' => 'Mozilla'
        ];
    }
    
    /**
     * @codeCoverageIgnore
     */
    protected function getSoapRequestRequestParameter(): array
    {
        return [
            'countryCode' => $this->getRequest()->getToCheckCountryCode(),
            'vatNumber' => $this->getRequest()->getToCheckSalesTaxNumber(),
            'traderName' => $this->getRequest()->getFirmenName(),
            'traderCompanyType' => '?',
            'traderStreet' => $this->getRequest()->getStrasse(),
            'traderPostcode' => $this->getRequest()->getPlz(),
            'traderCity' => $this->getRequest()->getOrt(),
            'requesterCountryCode' => $this->getRequest()->getOwnCountryCode(),
            'requesterVatNumber' => $this->getRequest()->getOwnSalesTaxNumber()
        ];
    }
}
 