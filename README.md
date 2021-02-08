# vatvalidation
/**
 * @author Frank Markwort
 * @version 1.0.0
 *
 * @copyright Frank Markwort
 * 
 * @example 
 * $query = new QueryCall(new Request(), new Response()); 
 * $query->getRequest()
 *     ->setDruck(false)
 *     ->setFirmenname('Ver d.o.o.')
 *     ->setOrt('Velika Gorica')
 *     ->setPlz('10410')
 *     ->setStrasse('Mate Lovraka 1')
 *     ->setUst1('DE263721827')
 *     ->setUst2('HR20543250589');
 * $response = $query->sendRequestToService()->getResponse();     
 * $response->getErrorCode();
 * $response->isValidUstId()
 */
