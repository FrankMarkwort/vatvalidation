# vatvalidation
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 * 
 * @example 
 * $query = new RequestController(new Request(), new Response()); 
 * $query->getRequest()<br>
         ->setDruck(false)<br>
         ->setFirmenname('Ver d.o.o.')<br>
         ->setOrt('Velika Gorica')<br>
         ->setPlz('10410')<br>
         ->setStrasse('Mate Lovraka 1')<br>
         ->setUst1('DE263721827')<br>
         ->setUst2('HR20543250589');
 * $response = $query->sendRequestToService()->getResponse();     
 * $errorCode = $response->getErrorCode();
 * $response->isValidUstId()
 */
