<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation\message;

interface RequestInterface
{
    public function setUst1(string $value): RequestInterface;

    public function setUst2(string $value): RequestInterface;
    
    public function setFirmenname(?string $value): RequestInterface;
     
    public function setOrt(?string $value): RequestInterface;
    
    public function setPlz(?string $value): RequestInterface;
     
    public function setStrasse(?string $value): RequestInterface;
       
    public function setDruck(bool $value): RequestInterface;
    
    public function getUst1(): string;
    
    public function getUst2(): string;
    
    public function getFirmenName(): ?string;
    
    public function getOrt(): ?string;
    
    public function getPlz(): ?string;
    
    public function getStrasse(): ?string;
    
    public function getDruck(): bool;
    
    public function getToCheckCountryCode(): string;
    
    public function getToCheckSalesTaxNumber(): string;
    
    public function getOwnCountryCode(): string;
    
    public function getOwnSalesTaxNumber(): string;
}

