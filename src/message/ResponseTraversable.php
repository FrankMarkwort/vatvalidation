<?php
/**
* @author Frank Markwort
* @version 1.0.0
*
* @copyright Frank Markwort
*
*/
namespace poseidon\vatvalidation\message;

use \IteratorAggregate;
use \ArrayIterator;

class ResponseTraversable extends AbstractResponceFacade implements ResponseInterface, IteratorAggregate
{
    public function getIterator ()
    {
        return new ArrayIterator([
            'ErgName' => $this->getErgName(),
            'ErgOrt' => $this->getErgOrt(),
            'ErgPlz' => $this->getErgPlz(),
            'ErgStr' => $this->getErgStr(),
            'FirmenName' => $this->getFirmenName(),
            'GueltigAb' => $this->getGueltigAb(),
            'GueltigBis' => $this->getGueltigBis(),
            'ErrorCode' => $this->getErrorCode(),
            'ErrorMessage' => $this->getErrorMessage(),
            'date' => $this->getDatum()
        ]);
    }
}
