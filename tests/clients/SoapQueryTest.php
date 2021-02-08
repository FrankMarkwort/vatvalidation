<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace tests\unit\validateVat\clients;

use PHPUnit\Framework\TestCase;
use src\validateVat\message\Response;
use src\validateVat\message\Request;
use tests\unit\validateVat\mocks\SoapQueryMock;
use \stdClass;

class SoapQueryTest extends TestCase
{
    /**
     * 
     * @var SoapQueryMock
     */
    protected $query;
    
    protected function setUp(): void
    {
        $this->query = new SoapQueryMock(new Request(), new Response());
    }
    
    public function testRequestInvalid()
    {
        $this->query->setMockResult($this->getSoapResultNotValid());
        $this->query->getRequest()->setUst1('HR20543250589')->setUst2('DE263721827H');
        $this->query->sendRequestToService();
        $this->assertFalse(false, $this->query->getResponse()->getDruck(), 'getDruck');
        $this->assertEquals('DE263721827H', $this->query->getResponse()->getUstId2(), 'getUstId2');
        $this->assertEquals('27-01-2021', $this->query->getResponse()->getDatum(), 'getDatum');
        $this->assertEquals('00:00:00', $this->query->getResponse()->getUhrzeit(), 'getUhrzeit');
        $this->assertEquals(201, $this->query->getResponse()->getErrorCode(), 'getErrorCode');
        $this->assertFalse($this->query->getResponse()->isValidUstId(), 'isValidUstId');        
    }
    
    public function testValidRequest()
    {
        $this->query->setMockResult($this->getSoapResultValid());
        $this->query->getRequest()->setUst1('HR20543250589')->setUst2('DE263721827');
        $this->query->sendRequestToService();
        $this->assertFalse(false, $this->query->getResponse()->getDruck(), 'getDruck');
        $this->assertEquals('DE263721827', $this->query->getResponse()->getUstId2(), 'getUstId2');
        $this->assertEquals('27-01-2021', $this->query->getResponse()->getDatum(), 'getDatum');
        $this->assertEquals('00:00:00', $this->query->getResponse()->getUhrzeit(), 'getUhrzeit');
        $this->assertEquals(200, $this->query->getResponse()->getErrorCode(), 'getErrorCode');
        $this->assertTrue($this->query->getResponse()->isValidUstId(), 'isValidUstId');        
    }
    
    public function testValidRequestWithAddress()
    {
        $this->query->setMockResult($this->getSoapResultValidWitAddress());
        $this->query->getRequest()
            ->setDruck(false)
            ->setFirmenname('Ver d.o.o.')
            ->setOrt('Velika Gorica')
            ->setPlz('10410')
            ->setStrasse('Mate Lovraka 1')
            ->setUst1('DE263721827')
            ->setUst2('HR20543250589');
        $this->query->sendRequestToService();
        $this->assertFalse(false, $this->query->getResponse()->getDruck(), 'getDruck');
        $this->assertEquals('HR20543250589', $this->query->getResponse()->getUstId2(), 'getUstId2');
        $this->assertEquals('27-01-2021', $this->query->getResponse()->getDatum(), 'getDatum');
        $this->assertEquals('00:00:00', $this->query->getResponse()->getUhrzeit(), 'getUhrzeit');
        $this->assertEquals('200', $this->query->getResponse()->getErrorCode(), 'getErrorCode');
        $this->assertTrue($this->query->getResponse()->isValidUstId(), 'isValidUstId');
    }
    
    public function testSoapFault()
    {
        $this->query->setMockResult('SOAP_FAULD');
        $this->query->getRequest()
        ->setDruck(false)
        ->setFirmenname('Ver d.o.o.')
        ->setOrt('Velika Gorica')
        ->setPlz('10410')
        ->setStrasse('Mate Lovraka 1')
        ->setUst1('DE263721827FALSE')
        ->setUst2('HR20543250589');
        $this->query->sendRequestToService();
        $this->assertFalse(false, $this->query->getResponse()->getDruck(), 'getDruck');
        $this->assertEquals(null, $this->query->getResponse()->getUstId2(), 'getUstId2');
        $this->assertEquals(null, $this->query->getResponse()->getDatum(), 'getDatum');
        $this->assertEquals(null, $this->query->getResponse()->getUhrzeit(), 'getUhrzeit');
        $this->assertEquals(221, $this->query->getResponse()->getErrorCode(), 'getErrorCode');
        $this->assertNull($this->query->getResponse()->isValidUstId(), 'isValidUstId');
    }
    
    public function testResultHaveWrongDate()
    {
        $this->query->setMockResult($this->getSoapResultWithNoDate());
        $this->query->getRequest()
        ->setDruck(false)
        ->setFirmenname('Ver d.o.o.')
        ->setOrt('Velika Gorica')
        ->setPlz('10410')
        ->setStrasse('Mate Lovraka 1')
        ->setUst1('DE263721827FALSE')
        ->setUst2('HR20543250589');
        $this->query->sendRequestToService();
        $this->assertEquals(null, $this->query->getResponse()->getDatum(), 'getDatum');
        $this->assertEquals(null, $this->query->getResponse()->getUhrzeit(), 'getUhrzeit');
        $this->assertEquals(200, $this->query->getResponse()->getErrorCode(), 'getErrorCode');
    }
    
    protected function getSoapResultNotValid()
    {
        $result = new stdClass();        
        $result->countryCode = "DE";
        $result->vatNumber = "263721827H";
        $result->requestDate = "2021-01-27+01:00";
        $result->valid = false;
        $result->traderName = null;
        $result->traderCompanyType = "?";
        $result->requestIdentifier = "";
        
        return $result;
    }
    
    protected function getSoapResultValid()
    {
        $result = new stdClass();
        $result->countryCode = "DE";
        $result->vatNumber = "263721827";
        $result->requestDate = "2021-01-27+01:00";
        $result->valid = true;
        $result->traderName = null;
        $result->traderCompanyType = "?";
        $result->requestIdentifier = "WAPIAAAAXdDYrZ2H";
        
        return $result;
    }
    
    protected function getSoapResultValidWitAddress()
    {
        $result = new stdClass();  
        $result->countryCode = "HR";
        $result->vatNumber = "20543250589";
        $result->requestDate = "2021-01-27+01:00";
        $result->valid = true;
        $result->traderName = 'VER D.O.O.';
        $result->traderCompanyType = "---";
        $result->traderAddress = 'LOVRAKA MATE 1, VELIKA GORICA, 10410 VELIKA GORICA';
        $result->requestIdentifier = "WAPIAAAAXdDeF-WB";
        
        return $result;
    }
    
    protected function getSoapResultWithNoDate()
    {
        $result = new stdClass();
        $result->countryCode = "HR";
        $result->vatNumber = "20543250589";
        $result->requestDate = "";
        $result->valid = true;
        $result->traderName = 'VER D.O.O.';
        $result->traderCompanyType = "---";
        $result->traderAddress = 'LOVRAKA MATE 1, VELIKA GORICA, 10410 VELIKA GORICA';
        $result->requestIdentifier = "WAPIAAAAXdDeF-WB";
        
        return $result;
    }
    
    protected function getSoapFault()
    {
        throw new \SoapFault(122, 'dddddd');
        $result = new stdClass();
        $result->countryCode = null;
        $result->vatNumber = null;
        $result->traderName = null;
        $result->requestDate = null;
        $result->valid = '221';
        $result->requestDate = null;
        
        return $result;
    }   
}
