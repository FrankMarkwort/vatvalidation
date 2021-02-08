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
use src\validateVat\message\Request;
use src\validateVat\message\Response;
use tests\unit\validateVat\mocks\CurlQueryMock;
use src\validateVat\config\Definitions;


class CurlQueryTest extends TestCase
{
    /**
     * 
     * @var CurlQueryMock
     */
    protected $query;
    
    protected function setUp(): void
    {
        $this->query = new CurlQueryMock(new Request(), new Response());  
        $this->query->setMockResult($this->getTestXmLData());
    }
    
    public function testRequest()
    {
        
        $this->query->getRequest()
            ->setDruck(false)
            ->setFirmenname('Ver d.o.o.')
            ->setOrt('Velika Gorica')
            ->setPlz('10410')
            ->setStrasse('Mate Lovraka 1')
            ->setUst1('DE263721827')
            ->setUst2('HR20543250589');
        
            
        $response = $this->query->sendRequestToService()->getResponse();
        $this->assertEquals('Ver d.o.o.', $response->getFirmenName(), 'getFirmenName');
        $this->assertEquals('Velika Gorica', $response->getOrt(), 'getOrt');
        $this->assertEquals('10410', $response->getPlz(), 'getPlz');
        $this->assertEquals('Mate Lovraka 1', $response->getStrasse(), 'getStrasse');
        $this->assertEquals('DE263721827', $response->getUstid1(), 'getUstid1');
        $this->assertEquals('HR20543250589', $response->getUstId2(), 'getUstId2');
        $this->assertEquals('24.01.2021', $response->getDatum(), 'getDatum');
        $this->assertEquals('', $response->getGueltigAb(), 'getGueltigAb');
        $this->assertEquals('', $response->getGueltigBis(), 'getGueltigBis');
        $this->assertEquals(false, $response->getDruck(), 'getDruck');
        $this->assertEquals('A', $response->getErgName(), 'getErgName');
        $this->assertEquals('A', $response->getErgOrt(), 'getErgOrt');
        $this->assertEquals('', $response->getErgPlz(), 'getErgPlz');
        $this->assertEquals('200', $response->getErrorCode(), 'getErrorCode');
        $this->assertEquals('19:40:22', $response->getUhrzeit(), 'getUhrzeit');
        $this->assertEquals('24.01.2021', $response->getDatum(), 'getDatum');
        $this->assertEquals(
            'UstId_1=DE263721827&UstId_2=HR20543250589&Firmenname=Ver+d.o.o.&Ort=Velika+Gorica&PLZ=10410&Strasse=Mate+Lovraka+1&Druck=nein', 
            $this->query->publicGetRequestUrl(),
            'GetRequestUrl'
        );
       
    }
    
    public function testEmptyRequest()
    {
        $this->query->getRequest()
        ->setDruck(false)
        ->setFirmenname('')
        ->setOrt('')
        ->setPlz('')
        ->setStrasse('')
        ->setUst1('')
        ->setUst2('');
        
        $this->assertEquals(
            'Druck=nein',
            $this->query->publicGetRequestUrl(),
            'GetRequestUrl'
        );
        
    }
    
    public function testIfCurlResultFalse()
    {
        $this->query->getRequest()
            ->setDruck(false)
            ->setFirmenname('Ver d.o.o.')
            ->setOrt('Velika Gorica')
            ->setPlz('10410')
            ->setStrasse('Mate Lovraka 1')
            ->setUst1('DE263721827')
            ->setUst2('HR20543250589');
        $this->query->setMockResult(false);
        $this->query->sendRequestToService();
        $this->assertEquals(Definitions::ERROR_CODE_SERVICE_NOT_AVAILABLE, $this->query->getResponse()->getErrorCode());
    }
    
    public function testIfCurlResultEmptyString()
    {
        $this->query->getRequest()
        ->setDruck(false)
        ->setFirmenname('Ver d.o.o.')
        ->setOrt('Velika Gorica')
        ->setPlz('10410')
        ->setStrasse('Mate Lovraka 1')
        ->setUst1('DE263721827')
        ->setUst2('HR20543250589');
        $this->query->setMockResult('');
        $this->query->sendRequestToService();
        $this->assertEquals(Definitions::ERROR_CODE_INVALID_REQUEST_DATA, $this->query->getResponse()->getErrorCode());
    }
    
    protected function getTestXmLData()
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

