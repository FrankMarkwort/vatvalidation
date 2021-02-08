<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace tests\unit\validateVat\mocks;

use src\validateVat\clients\SoapQuery;
use src\validateVat\exceptions\ValidateVatException;
use src\validateVat\config\Definitions;

class SoapQueryMock extends SoapQuery
{
    public $soapResult;
    
    public function setMockResult($soapResult)
    {
        $this->soapResult = $soapResult;
    }
       
    protected function serviceCall($url)
    {
        if ($this->soapResult == 'SOAP_FAULD') {
            
            throw new ValidateVatException('soap call error', Definitions::ERROR_CODE_INVALID_REQUEST_DATA);
        }
        return $this->soapResult;
    }  
}
