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

class Response implements ResponseInterface
{        
    protected $ustid1;
    protected $ustId2;
    protected $druck = false;
    protected $firmenName;
    protected $plz;
    protected $ort;
    protected $strasse;
    protected $ergName;
    protected $ergPlz;
    protected $ergOrt;
    protected $ergStr;
    protected $gueltigAb;
    protected $gueltigBis;
    protected $datum;
    protected $uhrzeit;
    protected $errorCode;
    
    public function getUstid1(): ?string
    {
        return $this->ustid1;
    }

    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }
    
    public function getErrorMessage():?string
    {
        return Definitions::getMessage($this->getErrorCode());
    }
    
    public function getMappedErrorCode(): ?string
    {
        return Definitions::getMappedErrorCode($this->getErrorCode());
    }
    
    public function getUstId2(): ?string
    {
        return $this->ustId2;
    }

    public function getDruck(): bool
    {
        return $this->druck;
    }

    public function getErgPlz(): ?string
    {
        return $this->ergPlz;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function getDatum(): ?string
    {
        return $this->datum;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function getErgOrt(): ?string
    {
        return $this->ergOrt;
    }

    public function getUhrzeit(): ?string
    {
        return $this->uhrzeit;
    }

    public function getErgName(): ?string
    {
        return $this->ergName;
    }

    public function getGueltigAb(): ?string
    {
        return $this->gueltigAb;
    }

    public function getGueltigBis(): ?string
    {
        return $this->gueltigBis;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function getFirmenName(): ?string
    {
        return $this->firmenName;
    }

    public function getErgStr(): ?string
    {
        return $this->ergStr;
    }

    public function setUstid1($ustid1): ResponseInterface
    {
        $this->ustid1 = $ustid1;
        
        return $this;
    }

    public function setErrorCode(int $errorCode): ResponseInterface
    {
        $this->errorCode = $errorCode;
        
        return $this;
    }
    
 
    public function setUstId2($ustId2): ResponseInterface
    {
        $this->ustId2 = $ustId2;
        
        return $this;
    }

    public function setDruck(bool $druck): ResponseInterface
    {
        $this->druck = $druck;
        
        return $this;
    }

    public function setErgPlz($ergPlz): ResponseInterface
    {
        $this->ergPlz = $ergPlz;
        
        return $this;
    }

    public function setOrt($ort): ResponseInterface
    {
        $this->ort = $ort;
        
        return $this;
    }

    public function setDatum(?string $datum): ResponseInterface
    {
        $this->datum = $datum;
        
        return $this;
    }

    public function setPlz($plz): ResponseInterface
    {
        $this->plz = $plz;
        
        return $this;
    }

    public function setErgOrt(?string $ergOrt): ResponseInterface
    {
        $this->ergOrt = $ergOrt;
        
        return $this;
    }

    public function setUhrzeit(?string $uhrzeit): ResponseInterface
    {
        $this->uhrzeit = $uhrzeit;
        
        return $this;
    }

    public function setErgName(?string $ergName): ResponseInterface
    {
        $this->ergName = $ergName;
        
        return $this;
    }

    public function setGueltigAb($gueltigAb): ResponseInterface
    {
        $this->gueltigAb = $gueltigAb;
        
        return $this;
    }

    public function setGueltigBis($gueltigBis): ResponseInterface
    {
        $this->gueltigBis = $gueltigBis;
        
        return $this;
    }

    public function setStrasse($strasse): ResponseInterface
    {
        $this->strasse = $strasse;
        
        return $this;
    }

    public function setFirmenName($firmenName): ResponseInterface    {
        $this->firmenName = $firmenName;
        
        return $this;
    }

    public function setErgStr(?string $ergStr): ResponseInterface
    {
        $this->ergStr = $ergStr;
        
        return $this;
    } 
    /**
     * 
     * @return bool|NULL
     * @desc Returns 
       true if the VAT registration number is valid. 
       false if this is invalid.
       null if a check was not possible.
     */
    public function isValidUstId():? bool
    {
        return Definitions::isValid($this->getErrorCode());
    }
    
    public function isValidResultOfTheCompleteAddressCheck(): ?bool
    {
        if (is_null($this->isValidResultName()) ||
            is_null($this->isValidResultPostCode()) ||
            is_null($this->isValidResultCity()) ||
            is_null($this->isValidResultStreet())) {
        
            return null;
        }
        
        return $this->isValidResultName() &&
            $this->isValidResultPostCode() &&
            $this->isValidResultCity() &&
            $this->isValidResultStreet();
    }
    
    public function isValidResultPostCode(): ?bool
    {
        return Definitions::isAddressValid($this->ergPlz);
    }
    
    public function isValidResultCity(): ?bool
    {
        return Definitions::isAddressValid($this->ergOrt);
    }
    
    public function isValidResultName(): ?bool
    {
        return Definitions::isAddressValid($this->ergName);
    }
    
    public function isValidResultStreet(): ?bool
    {
        return Definitions::isAddressValid($this->ergStr);
    }
    
    public function getResultMessagePostCode(): ?string
    {
        return Definitions::getAddressMessage($this->ergPlz);
    }
    
    public function getResultMessageCity(): ?string
    {
        return Definitions::getAddressMessage($this->ergOrt);
    }
    
    public function getResultMessageName(): ?string
    {
        return Definitions::getAddressMessage($this->ergName);
    }
    
    public function getResultMessageStreet(): ?string
    {
        return Definitions::getAddressMessage($this->ergStr);
    }
}
