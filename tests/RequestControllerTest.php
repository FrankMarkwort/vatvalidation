<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation;

use PHPUnit\Framework\TestCase;
use poseidon\vatvalidation\message\Response;
use poseidon\vatvalidation\message\Request;
use poseidon\vatvalidation\clients\CurlQuery;
use poseidon\vatvalidation\clients\SoapQuery;
use \stdClass;
use poseidon\vatvalidation\validate\VatNumberFormat;
use poseidon\vatvalidation\mocks\RequestControllerMock;

class RequestControllerTest extends TestCase
{
    /**
     * 
     * @var \tests\unit\validateVat\mocks\RequestControllerMock
     */
    protected $query;
    
    protected function setUp(): void
    {
        $this->query = new RequestControllerMock(new Request(), new Response());  
    }
    
    public function testExampleCall()
    {
        $request = $this->query->getRequest();
        $request->setDruck(false)
            ->setFirmenname('Ver d.o.o.')
            ->setOrt('Velika Gorica')
            ->setPlz('10410')
            ->setStrasse('Mate Lovraka 1')
            ->setUst1('DE263721827')
            ->setUst2('HR20543250589');
        $validate = new VatNumberFormat($request);
        if ($validate->isValid()) {
            /**
             *  Ust2 hat ein falsches Format
             */    
        }
        $this->assertTrue($validate->isValid());
        $this->mockHelperUseCurlOrSoap();
        $this->query->sendRequestToService();
        $respose = $this->query->getResponse();
        $isValidUstId = $respose->isValidUstId();
    }
    
    public function testCallCurlService()
    {
        $this->query->getRequest()
            ->setDruck(false)
            ->setFirmenname('Ver d.o.o.')
            ->setOrt('Velika Gorica')
            ->setPlz('10410')
            ->setStrasse('Mate Lovraka 1')
            ->setUst1('DE263721827')
            ->setUst2('HR20543250589');
        $this->assertFalse($this->query->isSoapMockService());
        $this->assertTrue($this->query->isCurlMockService());
        $this->query->setMockResult($this->getTestCurlResultData());
        $this->query->sendRequestToService();
        $this->assertInstanceOf(CurlQuery::class, $this->query->getMockQuery());
        $this->assertInstanceOf(Response::class, $this->query->getResponse());
    }
    
    public function testCallSoapService()
    {
        $this->query->getRequest()
        ->setDruck(false)
        ->setFirmenname('Ver d.o.o.')
        ->setOrt('Velika Gorica')
        ->setPlz('10410')
        ->setStrasse('Mate Lovraka 1')
        ->setUst1('HR20543250589')
        ->setUst2('DE263721827');
        $this->assertTrue($this->query->isSoapMockService());
        $this->assertFalse($this->query->isCurlMockService());
        $this->query->setMockResult($this->getTestSoapResultData());
        $this->query->sendRequestToService();
        $this->assertInstanceOf(SoapQuery::class, $this->query->getMockQuery());
        $this->assertInstanceOf(Response::class, $this->query->getResponse());
    }
    
    protected function getTestSoapResultData()
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
    
    protected function mockHelperUseCurlOrSoap()
    {
        if ($this->query->isSoapMockService()) {
            $this->query->setMockResult($this->getTestSoapResultData());
        } elseif ($this->query->isCurlMockService()) {
            $this->query->setMockResult($this->getTestCurlResultData());
        }
    }
    
    protected function getTestCurlResultData()
    {
        return <<<XMLA
<params>
<param>
<value><array><data>
<value><string>UstId_1</string></value>
<value><string>DE263721827</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>ErrorCode</string></value>
<value><string>200</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>UstId_2</string></value>
<value><string>HR20543250589</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Druck</string></value>
<value><string>nein</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Erg_PLZ</string></value>
<value><string>A</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Ort</string></value>
<value><string>Velika Gorica</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Datum</string></value>
<value><string>24.01.2021</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>PLZ</string></value>
<value><string>10410</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Erg_Ort</string></value>
<value><string>A</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Uhrzeit</string></value>
<value><string>19:40:22</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Erg_Name</string></value>
<value><string>A</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Gueltig_ab</string></value>
<value><string></string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Gueltig_bis</string></value>
<value><string></string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Strasse</string></value>
<value><string>Mate Lovraka 1</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Firmenname</string></value>
<value><string>Ver d.o.o.</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Erg_Str</string></value>
<value><string>A</string></value>
</data></array></value>
</param>
</params>
XMLA;
    }
    
public function getData() 
{
    
    return <<<XML
<params>
<param>
<value><array><data>
<value><string>UstId_1</string></value>
<value><string>DE263721827</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>ErrorCode</string></value>
<value><string>217</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>UstId_2</string></value>
<value><string>HR20543250589</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Druck</string></value>
<value><string>nein</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Erg_PLZ</string></value>
<value><string></string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Ort</string></value>
<value><string>Velika Gorica</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Datum</string></value>
<value><string>23.01.2021</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>PLZ</string></value>
<value><string>10410</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Erg_Ort</string></value>
<value><string></string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Uhrzeit</string></value>
<value><string>01:06:51</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Erg_Name</string></value>
<value><string></string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Gueltig_ab</string></value>
<value><string></string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Gueltig_bis</string></value>
<value><string></string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Strasse</string></value>
<value><string>Mate Lovraka 1</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Firmenname</string></value>
<value><string>Ver d.o.o.</string></value>
</data></array></value>
</param>
<param>
<value><array><data>
<value><string>Erg_Str</string></value>
<value><string></string></value>
</data></array></value>
</param>
</params>
XML;
    }
}

