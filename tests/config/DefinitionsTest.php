<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation\config;

use PHPUnit\Framework\TestCase;

class DefinitionsTest extends TestCase
{
    public function testIsValid()
    {
        $this->assertTrue(Definitions::isValid(200));
        $this->assertEquals(
            'Die angefragte USt-IdNr. ist gültig.', 
            Definitions::getMessage(200)
        );    
    }
    
    public function testIsNotValid()
    {
        $this->assertFalse(Definitions::isValid(212));
        $this->assertEquals(
            'Die angefragte USt-IdNr. ist ungültig. Sie enthält ein unzulässiges Länderkennzeichen.', 
            Definitions::getMessage(212)
        );
    }
    
    public function testIsUndefined()
    {
        $this->assertNull(Definitions::isValid(213));
        $this->assertEquals(
            'Die Abfrage einer deutschen USt-IdNr. ist nicht möglich.', 
            Definitions::getMessage(213)
        );   
    }
    
    public function testGetMessageWithInvalidNumber()
    {
        $this->assertEquals('An unknown error has occurred.', Definitions::getMessage(19999));
        $this->assertNull(Definitions::getMessage(null));
    }
    
    public function testMessageCodeNumberNotExist()
    {
        $this->assertNull(Definitions::isValid(19999));
    }
    
    public function testMessageCodeNumberNotExistMessage()
    {
        $this->assertNull(Definitions::isValid(19999));
    }
    
    public function testErrorNumberNotExist()
    {
        $this->assertFalse(Definitions::isErrorNumberExist(199));
        $this->assertFalse(Definitions::isErrorNumberExist(1000));
    }
    
    public function testGetMappedErrorCode()
    {
        $this->assertEquals(0, Definitions::getMappedErrorCode(201));
        $this->assertEquals(1, Definitions::getMappedErrorCode(10000));
        $this->assertNull(Definitions::getMappedErrorCode(null));
        ;
    }
    
    public function testAllNumbersExists()
    {
        for ($i = 200; $i <= 221; $i++) {
            $this->assertTrue(Definitions::isErrorNumberExist($i));
        }
        $this->assertTrue(Definitions::isErrorNumberExist(999));
    }
    
    public function testIsValidAdress() 
    {
        $this->assertTrue(Definitions::isAddressValid('A'));
        $this->assertFalse(Definitions::isAddressValid('B'));
        $this->assertNull(Definitions::isAddressValid('C'));
        $this->assertNull(Definitions::isAddressValid('D'));
        $this->assertNull(Definitions::isAddressValid('Z'));
    }
    
    public function testGetAddressMessages()
    {
        $this->assertEquals('stimmt überein', Definitions::getAddressMessage('A'));
        $this->assertEquals('stimmt nicht überein', Definitions::getAddressMessage('B'));
        $this->assertEquals('nicht angefragt', Definitions::getAddressMessage('C'));
        $this->assertEquals('vom EU-Mitgliedsstaat nicht mitgeteilt', Definitions::getAddressMessage('D'));
        $this->assertNull( Definitions::getAddressMessage('Z'));
    }
}
