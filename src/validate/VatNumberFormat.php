<?php
/**
* @author Frank Markwort
* @version 1.0.0
*
* @copyright Frank Markwort
*
*/
namespace poseidon\vatvalidation\validate;

use poseidon\vatvalidation\message\RequestInterface;

class VatNumberFormat
{
    protected $errorNumber;
    
    protected $patterns = array(
        'AT' => 'U[A-Z\d]{8}',
        'BE' => '[0|1]{1}\d{9}',
        'BG' => '\d{9,10}',
        'CH' => 'E(-| ?)(\d{3}(\.)\d{3}(\.)\d{3}|\d{9})( ?)(MWST|TVA|IVA)',
        'CY' => '\d{8}[A-Z]',
        'CZ' => '\d{8,10}',
        'DE' => '\d{9}',
        'DK' => '(\d{2} ?){3}\d{2}',
        'EE' => '\d{9}',
        'EL' => '\d{9}',
        'ES' => '[A-Z]\d{7}[A-Z]|\d{8}[A-Z]|[A-Z]\d{8}',
        'FI' => '\d{8}',
        'FR' => '([A-Z0-9]{2})\d{9}',
        'GB' => '\d{9}|\d{12}|(GD|HA)\d{3}',
        'HR' => '\d{11}',
        'HU' => '\d{8}',
        'IE' => '[A-Z\d]{8}|[A-Z\d]{9}',
        'IT' => '\d{11}',
        'LT' => '(\d{9}|\d{12})',
        'LU' => '\d{8}',
        'LV' => '\d{11}',
        'MT' => '\d{8}',
        'NL' => '\d{9}B\d{2}',
        'NO' => '\d{9}(MVA){0,1}',
        'PL' => '\d{10}',
        'PT' => '\d{9}',
        'RO' => '\d{2,10}',
        'SE' => '\d{12}',
        'SI' => '\d{8}',
        'SK' => '\d{10}'
    );
    
    protected $request;
    
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
    public function isValid(): bool 
    {
        return ($this->isValidUst1() && $this->isValidUst2()) && $this->isUst1NotEqualsUst2();          
    }
    
    public function isValidUst1(): bool
    {
        return $this->isValidCountryCodeAndVatId($this->getRequest()->getUst1());
    }
        
    public function isValidUst2(): bool
    {        
        return $this->isValidCountryCodeAndVatId($this->getRequest()->getUst2());
    }   
    
    public function isCountyCodeExist(string $countyCode):bool
    {
        return isset($this->patterns[strtoupper($countyCode)]);
    }
    
    protected function isValidCountryCodeAndVatId(string $fullVatId):bool
    {
        if (empty($fullVatId)) {
            
            return false;
        }    
        $countryCode =  strtoupper(substr($fullVatId, 0, 2));
        $vatId = substr($fullVatId, 2);  
        
        if (false === $this->isValidCountryCode($countryCode)) {
            
            return false;
        }
        if (0 === preg_match('/^(?:'.$this->patterns[$countryCode].')$/', $vatId)) {
            
            return false;
        }
        
        return true;
    }
    
    protected function isUst1NotEqualsUst2():bool
    {
        return $this->getRequest()->getUst1() !== $this->getRequest()->getUst2();
    }
    
    protected function isValidCountryCode($value):bool
    {
        return isset($this->patterns[$value]);
    }
}
