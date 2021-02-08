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
use src\validateVat\message\ResponseSerializable;
use src\validateVat\message\ResponseInterface;

class ResponseSerializableTest extends TestCase
{
    /**
     * 
     * @var ResponseSerializable
     */
    protected $response;
    
    protected function setUp(): void
    {
        $this->response = new ResponseSerializable();
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
    public function testSerializeAndUnserialize()
    {
        $this->response->setDatum('datum')
            ->setDruck(true)
            ->setErgName('ergName')
            ->setErgOrt('ergOrt')
            ->setErgPlz('ergPlz')
            ->setErgStr('ErgStr')
            ->setErrorCode(200)
            ->setFirmenName('FirmenName')
            ->setGueltigAb('GueltigAb')
            ->setGueltigBis('GueltigBis')
            ->setOrt('Ort')
            ->setPlz('Plz')
            ->setStrasse('Strasse')
            ->setUhrzeit('Uhrzeit')
            ->setUstid1('Ustid1')
            ->setUstId2('UstId2');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();        
        $newClass->unserialize($serialize);
        $this->assertEquals('datum', $newClass->getDatum());
        $this->assertTrue($newClass->getDruck());
        $this->assertEquals('ergName', $newClass->getErgName());
        $this->assertEquals('ergOrt', $newClass->getErgOrt());
        $this->assertEquals('ergPlz', $newClass->getErgPlz());
        $this->assertEquals('ErgStr', $newClass->getErgStr());
        $this->assertEquals(200, $newClass->getErrorCode());
        $this->assertEquals('Die angefragte USt-IdNr. ist gültig.', $newClass->getErrorMessage());
        $this->assertEquals('FirmenName', $newClass->getFirmenName());
        $this->assertEquals('GueltigAb', $newClass->getGueltigAb());
        $this->assertEquals('GueltigBis', $newClass->getGueltigBis());
        $this->assertEquals('Ort', $newClass->getOrt());
        $this->assertEquals('Plz', $newClass->getPlz());
        $this->assertEquals('Strasse', $newClass->getStrasse());
        $this->assertEquals('Uhrzeit', $newClass->getUhrzeit());
        $this->assertEquals('Ustid1', $newClass->getUstid1());
        $this->assertEquals('UstId2', $newClass->getUstId2()); 
    }  
    
    
    public function testIsValid()
    {
        $this->response->setErrorCode(200);
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertTrue($newClass->isValidUstId(), '200');
        $newClass->setErrorCode(211);
        $serialize2 = $newClass->serialize();
        $newClass2 = new ResponseSerializable();
        $newClass2->unserialize($serialize2);
        $this->assertFalse($newClass2->isValidUstId(), '211');
    }
    
    public function testsIsValidResultName()
    {
        $this->response->setErgName(null);
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultName());
        
        $this->response->setErgName('A');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertTrue($newClass->isValidResultName());
        
        $this->response->setErgName('B');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertFalse($newClass->isValidResultName());
        
        $this->response->setErgName('C');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultName());
        
        $this->response->setErgName('D');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultName());
        
        $this->assertEquals('kein Ergebnis' , $this->response->setErgName(null)->getResultMessageName());
        $this->assertEquals('stimmt überein' , $this->response->setErgName('A')->getResultMessageName());  
     }
    
    public function testResultPostalCode()
    {
        $this->response->setErgPlz(null);
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultPostCode());
        
        $this->response->setErgPlz('A');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertTrue($newClass->isValidResultPostCode());
        
        $this->response->setErgPlz('B');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertFalse($newClass->isValidResultPostCode());
        
        $this->response->setErgPlz('C');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultPostCode());
        
        $this->response->setErgPlz('D');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultPostCode());
        
        $this->assertEquals('kein Ergebnis' , $this->response->setErgPlz(null)->getResultMessagePostCode());
        $this->assertEquals('stimmt überein' , $this->response->setErgPlz('A')->getResultMessagePostCode());   
    }
    
    public function testResultCityCode()
    {
        $this->response->setErgOrt(null);
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultCity());
        
        $this->response->setErgOrt('A');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertTrue($newClass->isValidResultCity());
        
        $this->response->setErgOrt('B');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertFalse($newClass->isValidResultCity());
        
        $this->response->setErgOrt('C');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultCity());
        
        $this->response->setErgOrt('D');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultCity());
        
        $this->assertEquals('kein Ergebnis' , $this->response->setErgOrt(null)->getResultMessageCity());
        $this->assertEquals('stimmt überein' , $this->response->setErgOrt('A')->getResultMessageCity());   
    }
    
    public function testResultStreet()
    {
        $this->response->setErgStr(null);
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultStreet());
        
        $this->response->setErgStr('A');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertTrue($newClass->isValidResultStreet());
        
        $this->response->setErgStr('B');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertFalse($newClass->isValidResultStreet());
        
        $this->response->setErgStr('C');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultStreet());
        
        $this->response->setErgStr('D');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultStreet());
        
        $this->assertEquals('kein Ergebnis' , $this->response->setErgStr(null)->getResultMessageStreet());
        $this->assertEquals('stimmt überein' , $this->response->setErgStr('A')->getResultMessageStreet()); 
    }
    
    public function testIsValidResultOfTheCompleteAddressCheck()
    {
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultOfTheCompleteAddressCheck());
        
        $this->response->setErgName('A')->setErgOrt('A')->setErgPlz('A')->setErgStr('A');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertTrue($newClass->isValidResultOfTheCompleteAddressCheck());
        
        $this->response->setErgName('A')->setErgOrt('B')->setErgPlz('A')->setErgStr('A');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertFalse($newClass->isValidResultOfTheCompleteAddressCheck());
        
        $this->response->setErgName('A')->setErgOrt('C')->setErgPlz('A')->setErgStr('A');
        $serialize = $this->response->serialize();
        $newClass = new ResponseSerializable();
        $newClass->unserialize($serialize);
        $this->assertNull($newClass->isValidResultOfTheCompleteAddressCheck());
    }
}
