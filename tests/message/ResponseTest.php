<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation\message;

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * 
     * @var Response
     */
    protected $response;
    
    protected function setUp(): void
    {
        $this->response = new Response();        
    }
    
    public function testGetterReturnNull() 
    {
        $this->assertNull($this->response->getDatum());
        $this->assertFalse($this->response->getDruck());
        $this->assertNull($this->response->getErgName());
        $this->assertNull($this->response->getErgOrt());
        $this->assertNull($this->response->getErgPlz());
        $this->assertNull($this->response->getErgStr());
        $this->assertNull($this->response->getErrorCode());
        $this->assertNull($this->response->getFirmenName());
        $this->assertNull($this->response->getGueltigAb());
        $this->assertNull($this->response->getGueltigBis());
        $this->assertNull($this->response->getOrt());
        $this->assertNull($this->response->getPlz());
        $this->assertNull($this->response->getStrasse());
        $this->assertNull($this->response->getUhrzeit());
        $this->assertNull($this->response->getUstid1());
        $this->assertNull($this->response->getUstId2());
    }
       
    public function testSetterGetter()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setDatum('datum'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setDruck(true));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setErgName('ergName'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setErgOrt('ergOrt'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setErgPlz('ergPlz'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setErgStr('ErgStr'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setErrorCode(200));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setFirmenName('FirmenName'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setGueltigAb('GueltigAb'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setGueltigBis('GueltigBis'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setOrt('Ort'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setPlz('Plz'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setStrasse('Strasse'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setUhrzeit('Uhrzeit'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setUstid1('Ustid1'));
        $this->assertInstanceOf(ResponseInterface::class, $this->response->setUstId2('UstId2'));
        $this->assertEquals('datum', $this->response->getDatum());
        $this->assertTrue($this->response->getDruck());
        $this->assertEquals('ergName', $this->response->getErgName());
        $this->assertEquals('ergOrt', $this->response->getErgOrt());
        $this->assertEquals('ergPlz', $this->response->getErgPlz());
        $this->assertEquals('ErgStr', $this->response->getErgStr());
        $this->assertEquals(200, $this->response->getErrorCode());
        $this->assertEquals('Die angefragte USt-IdNr. ist gültig.', $this->response->getErrorMessage());
        $this->assertEquals('FirmenName', $this->response->getFirmenName());
        $this->assertEquals('GueltigAb', $this->response->getGueltigAb());
        $this->assertEquals('GueltigBis', $this->response->getGueltigBis());
        $this->assertEquals('Ort', $this->response->getOrt());
        $this->assertEquals('Plz', $this->response->getPlz());
        $this->assertEquals('Strasse', $this->response->getStrasse());
        $this->assertEquals('Uhrzeit', $this->response->getUhrzeit());
        $this->assertEquals('Ustid1', $this->response->getUstid1());
        $this->assertEquals('UstId2', $this->response->getUstId2());
    }
    
    public function testIsValid() 
    {
        $this->assertTrue($this->response->setErrorCode(200)->isValidUstId(), '200');
        $this->assertFalse($this->response->setErrorCode(211)->isValidUstId(), '211');
    }
    
    public function testResultName()
    {
        $this->assertNull($this->response->setErgName(null)->isValidResultName());
        
        $this->assertTrue($this->response->setErgName('A')->isValidResultName());
        $this->assertFalse($this->response->setErgName('B')->isValidResultName());
        $this->assertNull($this->response->setErgName('C')->isValidResultName());
        $this->assertNull($this->response->setErgName('D')->isValidResultName());
        $this->assertEquals('kein Ergebnis' , $this->response->setErgName(null)->getResultMessageName());
        $this->assertEquals('stimmt überein' , $this->response->setErgName('A')->getResultMessageName());   
    }
    
    public function testResultPostalCode()
    {
        $this->assertNull($this->response->setErgPlz(null)->isValidResultPostCode());
        $this->assertTrue($this->response->setErgPlz('A')->isValidResultPostCode());
        $this->assertFalse($this->response->setErgPlz('B')->isValidResultPostCode());
        $this->assertNull($this->response->setErgPlz('C')->isValidResultPostCode());
        $this->assertNull($this->response->setErgPlz('D')->isValidResultPostCode());
        $this->assertEquals('kein Ergebnis' , $this->response->setErgPlz(null)->getResultMessagePostCode());    
        $this->assertEquals('stimmt überein' , $this->response->setErgPlz('A')->getResultMessagePostCode());   
    }
    
    public function testResultCityCode()
    {
        $this->assertNull($this->response->setErgOrt(null)->isValidResultCity());
        $this->assertTrue($this->response->setErgOrt('A')->isValidResultCity());
        $this->assertFalse($this->response->setErgOrt('B')->isValidResultCity());
        $this->assertNull($this->response->setErgOrt('C')->isValidResultCity());
        $this->assertNull($this->response->setErgOrt('D')->isValidResultCity());
        $this->assertEquals('kein Ergebnis' , $this->response->setErgOrt(null)->getResultMessageCity());
        $this->assertEquals('stimmt überein' , $this->response->setErgOrt('A')->getResultMessageCity());   
    }
    
    public function testResultStreet()
    {
        $this->assertNull($this->response->setErgStr(null)->isValidResultStreet());
        $this->assertTrue($this->response->setErgStr('A')->isValidResultStreet());
        $this->assertFalse($this->response->setErgStr('B')->isValidResultStreet());
        $this->assertNull($this->response->setErgStr('C')->isValidResultStreet());
        $this->assertNull($this->response->setErgStr('D')->isValidResultStreet());
        $this->assertEquals('kein Ergebnis' , $this->response->setErgStr(null)->getResultMessageStreet());
        $this->assertEquals('stimmt überein' , $this->response->setErgStr('A')->getResultMessageStreet());   
    }
    
    public function testIsValidResultOfTheCompleteAddressCheck()
    {
        $this->assertNull($this->response->isValidResultOfTheCompleteAddressCheck());
        $this->response->setErgName('A')->setErgOrt('A')->setErgPlz('A')->setErgStr('A');
        $this->assertTrue($this->response->isValidResultOfTheCompleteAddressCheck());
        $this->response->setErgName('A')->setErgOrt('B')->setErgPlz('A')->setErgStr('A');
        $this->assertFalse($this->response->isValidResultOfTheCompleteAddressCheck());
        $this->response->setErgName('A')->setErgOrt('C')->setErgPlz('A')->setErgStr('A');
        $this->assertNull($this->response->isValidResultOfTheCompleteAddressCheck());
    }
    
    public function testGetMappedErrorCode()
    {
        $this->assertNull($this->response->getMappedErrorCode());      
        $this->response->setErrorCode(200);
        $this->assertEquals(1, $this->response->getMappedErrorCode()); 
    }
}
