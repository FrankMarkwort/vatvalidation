<?php
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 *
 */
namespace poseidon\vatvalidation\clients;

use poseidon\vatvalidation\message\RequestInterface;
use poseidon\vatvalidation\message\ResponseInterface;

interface QueryInterface
{     
    public function __construct(RequestInterface $request, ResponseInterface $response);
    
    public function sendRequestToService(): QueryInterface;
    
    public function getRequest(): RequestInterface;
    
    public function getResponse(): ResponseInterface;
}
