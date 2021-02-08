<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace tests\unit\validateVat\mocks;

use src\validateVat\clients\CurlQuery;

class CurlQueryMock extends CurlQuery
{
    public $xml = '';
    
    public function setMockResult($xml)
    {
        $this->xml = $xml;
    }
    
    public function publicGetRequestUrl()
    {
        return $this->getRequestUrl();  
    }
    
    protected function serviceCall($url)
    {
        return $this->xml;
    }  
}

