<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation\mocks;

use poseidon\vatvalidation\clients\QueryInterface;
use poseidon\vatvalidation\RequestController;

class RequestControllerMock extends RequestController
{
    protected $result;
    
    public function getMockQuery(): QueryInterface
    {
        return $this->query;
    }
    
    public function setMockResult($result)
    {
        $this->result = $result;
    }
    
     
    public function isCurlMockService():bool
    {
        return $this->isCurlService();
    }
    
    public function isSoapMockService():bool
    {
        return $this->isSoapService();
    }
    
    protected function setCurlQuery(): QueryInterface
    {
        $this->query = new CurlQueryMock($this->request, $this->responce);
        $this->query->setMockResult($this->result);
        
        return $this->query;
    }
    
    protected function setSoapQuery(): QueryInterface
    {
        $this->query = new SoapQueryMock($this->request, $this->responce);
        $this->query->setMockResult($this->result);
        
        return $this->query;
    }
}
