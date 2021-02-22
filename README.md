# vatvalidation
/**
 * @author Frank Markwort
 * @version 7.2.0
 * @email frank.markwort@gmail.com
 * @copyright Frank Markwort
 * 
 * @example
 * Request must implemented poseidon\vatvalidation\message\RequestInterface
 * Response must implemented poseidon\vatvalidation\message\ResponseInterface
 * 
 * use poseidon\vatvalidation\RequestController;
 * use poseidon\vatvalidation\message\Request;
 * use poseidon\vatvalidation\message\Response;
 * 
 * $requestController = new RequestController(new Request(), new Response()); 
 * $requestController->getRequest()<br>
         ->setDruck(false)<br>
         ->setFirmenname('Ver d.o.o.')<br>
         ->setOrt('Velika Gorica')<br>
         ->setPlz('10410')<br>
         ->setStrasse('Mate Lovraka 1')<br>
         ->setUst1('DE263721827')<br>
         ->setUst2('HR20543250589');
 * $response = $requestController->sendRequestToService()->getResponse();     
 * $errorCode = $response->getErrorCode();
 * $response->isValidUstId()
 */
