<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation\message;

interface ResponseInterface
{
    public function getUstid1(): ?string;
    
    public function getUstId2(): ?string;

    public function getErrorCode(): ?int;
    
    public function getMappedErrorCode(): ?string;
   
    public function getErrorMessage() :?string;
      
    public function getDruck(): bool;
    
    public function getErgPlz(): ?string;
    
    public function getOrt(): ?string;
    
    public function getDatum(): ?string;
    
    public function getPlz(): ?string;
    
    public function getErgOrt(): ?string;
    
    public function getUhrzeit(): ?string;
    
    public function getErgName(): ?string;
    
    public function getGueltigAb(): ?string;
    
    public function getGueltigBis(): ?string;
    
    public function getStrasse(): ?string;
    
    public function getFirmenName(): ?string;
    
    public function getErgStr(): ?string;
    
    public function setUstid1($ustid1): ResponseInterface;
    
    public function setErrorCode(int $errorCode): ResponseInterface;
      
    public function setUstId2($ustId2): ResponseInterface;
    
    public function setDruck(bool $druck): ResponseInterface;
    
    public function setErgPlz(?string $ergPlz): ResponseInterface;
    
    public function setOrt($ort): ResponseInterface;
     
    public function setDatum(?string $datum): ResponseInterface;
      
    public function setPlz($plz): ResponseInterface;
    
    public function setErgOrt(?string $ergOrt): ResponseInterface;
     
    public function setUhrzeit(?string $uhrzeit): ResponseInterface;
     
    public function setErgName(?string $ergName): ResponseInterface;
    
    public function setGueltigAb($gueltigAb): ResponseInterface;
    
    public function setGueltigBis($gueltigBis): ResponseInterface;
     
    public function setStrasse($strasse): ResponseInterface;
      
    public function setFirmenName($firmenName): ResponseInterface;
    
    public function setErgStr(?string $ergStr): ResponseInterface;
  
    /**
     * @desc 
     * true if the VAT registration number is valid.
     * false if this is invalid.
     * null if a check was not possible.
     */
    public function isValidUstId():? bool;
    
    /**
     * @desc If the zip code to be checked matches then the method returns the following
     * true f it is valid.
     * false if the the not invalid.
     * null if a check was not possible.
     */
    public function isValidResultPostCode(): ?bool;
    
    /**
     * @desc If the city to be checked matches then the method returns the following
     * true if it is valid.
     * false f it is not invalid.
     * null if a check was not possible.
     */
    public function isValidResultCity(): ?bool;
    
    /**
     * @desc If the name to be checked matches then the method returns the following
     * true if it is valid.
     * false f it is not invalid.
     * null if a check was not possible.
     */
    public function isValidResultName(): ?bool;
    
    /**
     * @desc If the street to be checked matches then the method returns the following
     * true if it is valid.
     * false f it is not invalid.
     * null if a check was not possible.
     */
    public function isValidResultStreet(): ?bool;
    
    /**
     * @desc If the pls, strasse, ort, name to be checked matches then the method returns the following
     * true if it is valid.
     * false f it is not invalid.
     * null if a check was not possible.
     */
    public function isValidResultOfTheCompleteAddressCheck(): ?bool;
    
    public function getResultMessagePostCode(): ?string;
    
    public function getResultMessageCity(): ?string;

    public function getResultMessageName(): ?string;
    
    public function getResultMessageStreet(): ?string;
}

