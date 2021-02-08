<?php
/**
* @author Frank Markwort
* @version 1.0.0
*
* @copyright Frank Markwort
*
*/
namespace poseidon\vatvalidation\message;

class ResponseSerializable extends AbstractResponceFacade implements ResponseSerializableInterface
{
    public function unserialize($serialized)
    {
        $class = unserialize(base64_decode($serialized));       
        if ($class instanceof ResponseInterface) {
            $this->response = $class;
        }
    }

    public function serialize(): string
    {
        return base64_encode(serialize($this->response));
    }
}
