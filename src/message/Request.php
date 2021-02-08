<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation\message;

use poseidon\vatvalidation\config\Definitions;

class Request implements RequestInterface
{           
    private const NAME_USTID_1 = 'UstId_1';
    private const NAME_USTID_2 = 'UstId_2';
    private const NAME_DRUCK = 'Druck';
    private const NAME_ORT = 'Ort';
    private const NAME_PLZ = 'PLZ';
    private const NAME_STRASSE = 'Strasse';
    private const NAME_FIRMENNAME = 'Firmenname';
    
    protected $ust1;
    protected $ust2;
    protected $firmenname;
    protected $ort;
    protected $plz;
    protected $strasse;
    protected $druck = false;
    
    private $firstField = true;
 
    public function setUst1(string $value): RequestInterface
    {
        $this->ust1 = trim($value);
        
        return $this;
    }

    public function setUst2(string $value): RequestInterface
    {
        $this->ust2 = trim($value);
        
        return $this;
    }

    public function setFirmenname(string $value): RequestInterface
    {
        $this->firmenname = $value;
        
        return $this;
    }

    public function setOrt(string $value): RequestInterface
    {
        $this->ort = $value;
        
        return $this;
    }

    public function setPlz(string $value): RequestInterface
    {
        $this->plz = $value;
        
        return $this;
    }

    public function setStrasse(string $value): RequestInterface
    {
        $this->strasse = $value;
        
        return $this;
    }

    public function setDruck(bool $value): RequestInterface
    {
        $this->druck = $value;
        
        return $this;
    } 
    
    public function getUst1(): string
    {
        return $this->ust1;
    }
    
    public function getUst2(): string
    {
        return $this->ust2;
    }
    
    public function getFirmenName(): ?string
    {
        return $this->firmenname;
    }
    
    public function getOrt(): ?string
    {
        return $this->ort;
    }
    
    public function getPlz(): ?string
    {
        return $this->plz;
    }
    
    public function getStrasse(): ?string
    {
        return $this->strasse;
    }
    
    public function getDruck(): bool
    {
        return $this->druck;
    } 
 
    public function getToCheckCountryCode(): string
    {
        return $this->getCountryCodeFromVatId($this->getUst2());
    }
    
    public function getToCheckSalesTaxNumber(): string
    {
        return $this->getVatIdFromFullVatid($this->getUst2());  
    }
    
    public function getOwnCountryCode(): string
    {
        return $this->getCountryCodeFromVatId($this->getUst1());
    }
    
    public function getOwnSalesTaxNumber(): string
    {
        return $this->getVatIdFromFullVatid($this->getUst1());
    }
    
    protected function getCountryCodeFromVatId(string $value):string 
    {
        return strtoupper(substr($value, 0, 2));
    }
    
    protected function getVatIdFromFullVatid(string $value):string
    {
        return substr($value, 2);
    }
}

