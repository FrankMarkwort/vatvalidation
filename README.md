# vatvalidation
/**
 * @author Frank Markwort
 * @version 7.2.0
 * @email frank.markwort@gmail.com
 * @copyright Frank Markwort
 * 
*/
# Configurations
```php
namespace poseidon\vatvalidation\config;

class Definitions
{
  // Mapped Return Codes
  private static $messages = [
        self::ERROR_CODE_IS_VALID => [
            self::MAPPED_CODE => 1,
            self::VALID => true, 
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist gültig.'
        ],       
        self::ERROR_CODE_IS_NOT_VALID => [
            self::MAPPED_CODE => 0,
            self::VALID => false,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist ungültig. Die angefragte USt-IdNr.'
        ],
        ...
    ];
}
```
# External Service URL's
```php
namespace poseidon\vatvalidation\clients;

class CurlQuery extends AbstractQuery implements QueryInterface
{
    protected static $SERVER_URL = 'https://evatr.bff-online.de/evatrRPC?';
    ....
}

class SoapQuery extends AbstractQuery implements QueryInterface
{
    protected static $SERVER_URL = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';
    ...
}
```
# Interfaces
Request must implemented *poseidon\vatvalidation\message\RequestInterface*\n
Response must implemented *poseidon\vatvalidation\message\ResponseInterface*

# @example 1 Response
```php
use poseidon\vatvalidation\RequestController;
use poseidon\vatvalidation\message\Request;
use poseidon\vatvalidation\message\Response;
  
$requestController = new RequestController(new Request(), new Response()); 
$requestController->getRequest()
    ->setDruck(false)
    ->setFirmenname('Ver d.o.o.')
    ->setOrt('Velika Gorica')
    ->setPlz('10410')
    ->setStrasse('Mate Lovraka 1')
    ->setUst1('DE263721827')
    ->setUst2('HR20543250589');
$response = $requestController->sendRequestToService()->getResponse();     
$errorCode = $response->getErrorCode();
$response->isValidUstId()
```
# @example 2 ResponseTraversable;
```php
use poseidon\vatvalidation\message\ResponseTraversable;

$requestController = new RequestController(new Request(), new ResponseTraversable());
    set Request
$response = $requestController->sendRequestToService()->getResponse(); 
foreach ($response as $key => $value) {
    do something
}
```
# @example 3 ResponseSerializable
```php
use poseidon\vatvalidation\message\ResponseSerializable;

$requestController = new RequestController(new Request(), new ResponseSerializable()); 
    set Request 
$response = $requestController->sendRequestToService()->getResponse(); 
$storeInDatabase = $requestController->sendRequestToService()->getResponse()->serialize();
    do something
$responseFromDatabase = (new ResponseSerializable())->unserialize($storeInDatabase);
```
## Pre-Validation request
```php
use poseidon\vatvalidation\validate\VatNumberFormat;

$request = new Request()
    set Request
$validator = new VatNumberFormat($request);
if ($validator->isValid()) {
    do something
} elseif($validator->isCountyCodeExist()) {
    do something
}
