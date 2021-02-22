# vatvalidation
/**
 * @author Frank Markwort
 * @version 7.2.0
 * @email frank.markwort@gmail.com
 * @copyright Frank Markwort
 * 
 * @example 1 Response
 * 
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
 * 
 * @example 2 ResponseTraversable;
 * 
 * use poseidon\vatvalidation\message\ResponseTraversable;
 * $requestController = new RequestController(new Request(), new ResponseTraversable());
 *     set Request
 * $response = $requestController->sendRequestToService()->getResponse(); 
 * foreach ($response as $key => $value) {
 *     do something
 * }
 * 
 * @example 3 ResponseSerializable
 * 
 * use poseidon\vatvalidation\message\ResponseSerializable;
 * 
 * $requestController = new RequestController(new Request(), new ResponseSerializable()); 
 *     set Request 
 * $response = $requestController->sendRequestToService()->getResponse(); 
 * $storeInDatabase = $requestController->sendRequestToService()->getResponse()->serialize();
 *      do something
 * $responseFromDatabase = (new ResponseSerializable())->unserialize($storeInDatabase);
 * 
 */
