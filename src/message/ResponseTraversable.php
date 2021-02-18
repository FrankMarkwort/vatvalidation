<?php
/**
* @author Frank Markwort
* @version 1.0.0
*
* @copyright Frank Markwort
*
*/
namespace poseidon\vatvalidation\message;

use \Traversable;

class ResponseTraversable extends AbstractResponceFacade implements ResponseInterface, Traversable
{
    public function getIterator ()
    {
        return [
            'ErrorCode' => $this->getErrorCode(),
            'ErrorMessage' => $this->getErrorMessage(),
            'date' => $this->getDatum()
        ];
    }
}
