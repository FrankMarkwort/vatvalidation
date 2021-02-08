<?php
namespace poseidon\vatvalidation\message;

abstract class AbstractResponceFacade
{
    /**
     * 
     * @var ResponseInterface
     */
    protected $response;
    
    public function __construct()
    {
        $this->response = new Response();
    }
    
    public function getUstid1(): ?string
    {
        return $this->response->getUstid1();
    }
    
    public function getErrorCode(): ?int
    {
        return $this->response->getErrorCode();
    }
    
    public function getMappedErrorCode(): ?string
    {
        return $this->response->getMappedErrorCode();
    }
    
    public function getErrorMessage(): ?string
    {
        return $this->response->getErrorMessage();
    }
    
    public function getUstId2(): ?string
    {
        return $this->response->getUstId2();
    }
    
    public function getDruck(): bool
    {
        return $this->response->getDruck();
    }
    
    public function getErgPlz(): ?string
    {
        return $this->response->getErgPlz();
    }
    
    public function getOrt(): ?string
    {
        return $this->response->getOrt();
    }
    
    public function getDatum(): ?string
    {
        return $this->response->getDatum();
    }
    
    public function getPlz(): ?string
    {
        return $this->response->getPlz();
    }
    
    public function getErgOrt(): ?string
    {
        return $this->response->getErgOrt();
    }
    
    public function getUhrzeit(): ?string
    {
        return $this->response->getUhrzeit();
    }
    
    public function getErgName(): ?string
    {
        return $this->response->getErgName();
    }
    
    public function getGueltigAb(): ?string
    {
        return $this->response->getGueltigAb();
    }
    
    public function getGueltigBis(): ?string
    {
        return $this->response->getGueltigBis();
    }
    
    public function getStrasse(): ?string
    {
        return $this->response->getStrasse();
    }
    
    public function getFirmenName(): ?string
    {
        return $this->response->getFirmenName();
    }
    
    public function getErgStr(): ?string
    {
        return $this->response->getErgStr();
    }
    
    public function setUstid1($ustid1): ResponseInterface
    {
        $this->response->setUstid1($ustid1);
        
        return $this;
    }
    
    public function setErrorCode(int $errorCode): ResponseInterface
    {
        $this->response->setErrorCode($errorCode);
        
        return $this;
    }
    
    
    public function setUstId2($ustId2): ResponseInterface
    {
        $this->response->setUstId2($ustId2);
        
        return $this;
    }
    
    public function setDruck(bool $druck): ResponseInterface
    {
        $this->response->setDruck($druck);
        
        return $this;
    }
    
    public function setErgPlz($ergPlz): ResponseInterface
    {
        $this->response->setErgPlz($ergPlz);
        
        return $this;
    }
    
    public function setOrt($ort): ResponseInterface
    {
        $this->response->setOrt($ort);
        
        return $this;
    }
    
    public function setDatum(?string $datum): ResponseInterface
    {
        $this->response->setDatum($datum);
        
        return $this;
    }
    
    public function setPlz($plz): ResponseInterface
    {
        $this->response->setPlz($plz);
        
        return $this;
    }
    
    public function setErgOrt(?string $ergOrt): ResponseInterface
    {
        $this->response->setErgOrt($ergOrt);
        
        return $this;
    }
    
    public function setUhrzeit(?string $uhrzeit): ResponseInterface
    {
        $this->response->setUhrzeit($uhrzeit);
        
        return $this;
    }
    
    public function setErgName(?string $ergName): ResponseInterface
    {
        $this->response->setErgName($ergName);
        
        return $this;
    }
    
    public function setGueltigAb($gueltigAb): ResponseInterface
    {
        $this->response->setGueltigAb($gueltigAb);
        
        return $this;
    }
    
    public function setGueltigBis($gueltigBis): ResponseInterface
    {
        $this->response->setGueltigBis($gueltigBis);
        
        return $this;
    }
    
    public function setStrasse($strasse): ResponseInterface
    {
        $this->response->setStrasse($strasse);
        
        return $this;
    }
    
    public function setFirmenName($firmenName): ResponseInterface    {
        $this->response->setFirmenName($firmenName);
        
        return $this;
    }
    
    public function setErgStr(?string $ergStr): ResponseInterface
    {
        $this->response->setErgStr($ergStr);
        
        return $this;
    }

    public function isValidUstId():? bool
    {
        return $this->response->isValidUstId();
    }
    
    public function isValidResultOfTheCompleteAddressCheck(): ?bool
    {
        return $this->response->isValidResultOfTheCompleteAddressCheck();
    }
    
    public function isValidResultPostCode(): ?bool
    {
        return $this->response->isValidResultPostCode();
    }
    
    public function isValidResultCity(): ?bool
    {
        return $this->response->isValidResultCity();
    }
    
    public function isValidResultName(): ?bool
    {
        return $this->response->isValidResultName();
    }
    
    public function isValidResultStreet(): ?bool
    {
        return $this->response->isValidResultStreet();
    }
    
    public function getResultMessagePostCode(): ?string
    {
        return $this->response->getResultMessagePostCode();
    }
    
    public function getResultMessageCity(): ?string
    {
        return $this->response->getResultMessageCity();
    }
    
    public function getResultMessageName(): ?string
    {
        return $this->response->getResultMessageName();
    }
    
    public function getResultMessageStreet(): ?string
    {
        return $this->response->getResultMessageStreet();
    }   
}
