<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 * 
 * @example 
 * $query = new QueryCall(new Request(), new Response()); 
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
namespace poseidon\vatvalidation;

use poseidon\vatvalidation\exceptions\ValidateVatException;
use poseidon\vatvalidation\clients\CurlQuery;
use poseidon\vatvalidation\clients\SoapQuery;
use poseidon\vatvalidation\clients\QueryInterface;
use poseidon\vatvalidation\message\RequestInterface;
use poseidon\vatvalidation\message\ResponseInterface;

class RequestController implements QueryInterface
{
    protected $responce;
    protected $request;
    protected $query;
    
    public function __construct(RequestInterface $request, ResponseInterface $response) 
    {
        $this->request = $request;  
        $this->responce = $response;
    }
        
    public function sendRequestToService():QueryInterface
    {
        if ($this->isCurlService()) {
            $this->setCurlQuery()->sendRequestToService();
            
            return $this;
        } 
        
        $this->setSoapQuery()->sendRequestToService();

        return $this;
    }
    
    public function getRequest():RequestInterface
    {
        return $this->request;
    }
    
    public function getResponse():ResponseInterface
    {
        return $this->responce;
    }
    
    /**
     * @codeCoverageIgnore
     * @throws ValidateVatException
     */
    protected function setCurlQuery(): QueryInterface
    {
        $this->query = new CurlQuery($this->request, $this->responce);
        
        return $this->query;
    }
    
    /**
     * @codeCoverageIgnore
     */
    protected function setSoapQuery(): QueryInterface
    {
        $this->query = new SoapQuery($this->request, $this->responce);
        
        return $this->query;
    }
        
    protected function isSoapService(): bool
    {
        if ($this->request->getToCheckCountryCode() === 'DE') {
            
            return true;
        }
        
        return false;
    }
    
    protected function isCurlService(): bool
    {
        return ! $this->isSoapService();
    }   
}

