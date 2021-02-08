<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace tests\unit\message\validateVat;

use PHPUnit\Framework\TestCase;
use src\validateVat\message\Request;

class RequestTest extends TestCase
{
    /**
     * 
     * @var Request
     */
    protected $request;
    
    protected function setUp(): void
    {
        $this->request = new Request();        
    }
    
    public function testSetterGetter()
    {       
        $this->assertEquals(false, $this->request->getDruck());
        $this->assertEquals(null, $this->request->getFirmenName());
        $this->assertEquals(null, $this->request->getOrt());
        $this->assertEquals(null, $this->request->getPlz());
        $this->assertEquals(null, $this->request->getStrasse());
        
        $this->assertInstanceOf(Request::class, $this->request->setDruck(true));
        $this->assertInstanceOf(Request::class, $this->request->setFirmenname('company'));
        $this->assertInstanceOf(Request::class, $this->request->setOrt('ort'));
        $this->assertInstanceOf(Request::class, $this->request->setPlz('plz'));
        $this->assertInstanceOf(Request::class, $this->request->setStrasse('strasse'));
        $this->assertInstanceOf(Request::class, $this->request->setUst1('ust1')); #validation
        $this->assertInstanceOf(Request::class, $this->request->setUst2('ust2'));
       
        $this->assertEquals(true, $this->request->getDruck());
        $this->assertEquals('company', $this->request->getFirmenName());
        $this->assertEquals('ort', $this->request->getOrt());
        $this->assertEquals('plz', $this->request->getPlz());
        $this->assertEquals('strasse', $this->request->getStrasse());
        $this->assertEquals('ust1', $this->request->getUst1());
        $this->assertEquals('ust2', $this->request->getUst2());
    }
    
    public function testGetCountryCode()
    {
        $this->request->setUst1('HU123456789')->setUst2('DE987654321');
        $this->assertEquals('DE', $this->request->getToCheckCountryCode());
        $this->assertEquals('987654321', $this->request->getToCheckSalesTaxNumber());  
        
        $this->assertEquals('HU', $this->request->getOwnCountryCode());
        $this->assertEquals('123456789', $this->request->getOwnSalesTaxNumber());  
    }  
}
