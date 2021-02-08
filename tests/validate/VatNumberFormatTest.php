<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation\validate;

use PHPUnit\Framework\TestCase;
use poseidon\vatvalidation\message\Request;
use poseidon\vatvalidation\validate\VatNumberFormat;

class VatNumberFormatTest extends TestCase
{
    /**
     * 
     * @var Request
     */
    protected $request;
    /**
     * 
     * @var VatNumberFormat
     */
    protected $validate;
    
    protected function setUp(): void
    {
        $this->validate = new VatNumberFormat(new Request());
    }
    /**
     * DE-Deutschland   DE999999999 1 Block mit 9 Ziffern
     */
    public function testDE() 
    {
        $this->validate->getRequest()->setUst1('DE123456789DD');
        $this->validate->getRequest()->setUst2('DE123456789');
        $this->assertFalse($this->validate->isValidUst1());
        $this->assertFalse($this->validate->isValid());
        $this->assertTrue($this->validate->isValidUst2());
        $this->validate->getRequest()->setUst1('DE123456789');
        $this->assertTrue($this->validate->isValidUst1());
        $this->validate->getRequest()->setUst2('DE123456780');
        $this->assertTrue($this->validate->isValidUst2());
        $this->assertTrue($this->validate->isValid());
        $this->assertTrue($this->validate->isValidUst2());
        $this->validate->getRequest()->setUst2('DE12345678');
        $this->assertFalse($this->validate->isValidUst2());
        $this->assertFalse($this->validate->isValid());
        $this->validate->getRequest()->setUst2('DE1234567890');
        $this->assertFalse($this->validate->isValidUst2());
        $this->assertFalse($this->validate->isValid());
        $this->validate->getRequest()->setUst2('');
        $this->assertFalse($this->validate->isValidUst2());
        $this->assertFalse($this->validate->isValid());
        $this->validate->getRequest()->setUst2('ZZ1234567890');
        $this->assertFalse($this->validate->isValidUst2());
        $this->assertFalse($this->validate->isValid());
        $this->validate->getRequest()->setUst2('DE12 345 6789');
        $this->assertFalse($this->validate->isValidUst2());
        $this->assertFalse($this->validate->isValid());
    }   
    
    public function lowercaseCounty()
    {
        $this->validate->getRequest()->setUst1('de123456789DD');
        $this->validate->getRequest()->setUst2('de123456789');
        $this->assertFalse($this->validate->isValidUst1());
        $this->assertFalse($this->validate->isValid());
        $this->assertTrue($this->validate->isValidUst2());
    }
    
    public function testCountryCodes()
    {
        $contyCodes = [
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL', 'ES', 'FI', 'FR', 'GB', 'HU', 'HR', 'IE',
            'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK'
        ];
        foreach ($contyCodes as $value) {
            $this->assertTrue($this->validate->isCountyCodeExist($value), $value);
        }
        $this->assertTrue($this->validate->isCountyCodeExist('es'), 'es');
        $this->assertFalse($this->validate->isCountyCodeExist('ZZ'), 'ZZ');
    }
}
