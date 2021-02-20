<?php
/**
* @author Frank Markwort
* @version 1.0.0
*
* @copyright Frank Markwort
*
*/
namespace poseidon\vatvalidation\config;


class Definitions
{
    private const VALID = 'valid';
    private const MESSAGGE = 'message';
    private const MAPPED_CODE = 'mapped';
    /* TODO Soap FAULT
    100 = Valid request with Valid VAT Number       => 200
    200 = Valid request with an Invalid VAT Number  => 201
    201 = Error : INVALID_INPUT                     => 
    202 = Error : INVALID_REQUESTER_INFO            => 
    300 = Error : SERVICE_UNAVAILABLE               => 999
    301 = Error : MS_UNAVAILABLE                    => 999
    302 = Error : TIMEOUT                           => 97
    400 = Error : VAT_BLOCKED
    401 = Error : IP_BLOCKED
    500 = Error : GLOBAL_MAX_CONCURRENT_REQ
    501 = Error : GLOBAL_MAX_CONCURRENT_REQ_TIME
    600 = Error : MS_MAX_CONCURRENT_REQ
    601 = Error : MS_MAX_CONCURRENT_REQ_TIME
    */
    
    public const ERROR_CODE_SERVICE_NOT_AVAILABLE = 999;
    public const ERROR_CODE_INVALID_REQUEST_DATA = 221;
    public const ERROR_CODE_IS_VALID = 200;
    public const ERROR_CODE_IS_NOT_VALID = 201;   
    public const ERROR_CODE_UNKNOWN = 9999; 
    PUBLIC const ADDRESS_RESULT_A = 'A';
    PUBLIC const ADDRESS_RESULT_B = 'B';
    PUBLIC const ADDRESS_RESULT_C = 'C';
    PUBLIC const ADDRESS_RESULT_D = 'D';
    
    private static $addressMessage = [
        self::ADDRESS_RESULT_A => [
            self::MAPPED_CODE => 1,
            self::VALID => true,
            self::MESSAGGE =>  'stimmt überein',
        ],
        self::ADDRESS_RESULT_B => [
            self::MAPPED_CODE => 2,
            self::VALID => false,
            self::MESSAGGE =>  'stimmt nicht überein',
        ],
        self::ADDRESS_RESULT_C => [
            self::MAPPED_CODE => 3,
            self::VALID => null,
            self::MESSAGGE =>  'nicht angefragt',
        ],
        self::ADDRESS_RESULT_D => [
            self::MAPPED_CODE => 4,
            self::VALID => null,
            self::MESSAGGE =>  'vom EU-Mitgliedsstaat nicht mitgeteilt',
        ],
            null => [
            self::MAPPED_CODE => 5,
            self::VALID => null,
            self::MESSAGGE =>  'kein Ergebnis',
        ]  
    ];
    
    private static $messages = [
        self::ERROR_CODE_IS_VALID => [
            self::MAPPED_CODE => 1,
            self::VALID => true, 
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist gültig.'
        ],       
        self::ERROR_CODE_IS_NOT_VALID => [
            self::MAPPED_CODE => 0,
            self::VALID => false,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist ungültig. Die angefragte USt-IdNr. ist ungültig. Sie ist nicht in der Unternehmerdatei des betreffenden EU-Mitgliedstaates registriert.'
        ], 
        202 => [
            self::MAPPED_CODE => 0,
            self::VALID => false,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist ungültig. Sie ist nicht in der Unternehmerdatei des betreffenden EU-Mitgliedstaates registriert.' . "\n"
                              . "Hinweis:\n"
                              . 'Ihr Geschäftspartner kann seine gültige USt-IdNr. bei der für ihn zuständigen Finanzbehörde in Erfahrung bringen. Möglicherweise muss er einen Antrag stellen, damit seine USt-IdNr. in die Datenbank aufgenommen wird.' 
        ],                    
        203 => [
            self::MAPPED_CODE => 0,
            self::VALID => false,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist ungültig. Sie ist erst ab dem ... gültig (siehe Feld "Gueltig_ab").'
        ],
        204 => [
            self::MAPPED_CODE => 0,
            self::VALID => false,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist ungültig. Sie war im Zeitraum von ... bis ... gültig (siehe Feld "Gueltig_ab" und "Gueltig_bis").'
        ],
        205 => [
            self::MAPPED_CODE => 0,
            self::VALID => null,
            self::MESSAGGE => "Ihre Anfrage kann derzeit durch den angefragten EU-Mitgliedstaat oder aus anderen Gründen nicht beantwortet werden. Bitte versuchen Sie es später noch einmal.\n"
                            . 'Bei wiederholten Problemen wenden Sie sich bitte an das Bundeszentralamt für Steuern - Dienstsitz Saarlouis.'           
        ],
        206 => [
            self::MAPPED_CODE => 0,
            self::VALID => false,
            self::MESSAGGE => 'Ihre deutsche USt-IdNr. ist ungültig. Eine Bestätigungsanfrage ist daher nicht möglich. Den Grund hierfür können Sie beim Bundeszentralamt für Steuern - Dienstsitz Saarlouis - erfragen.'
        ],
        207 => [
            self::MAPPED_CODE => 0,
            self::VALID => null, 
            self::MESSAGGE => 'Ihnen wurde die deutsche USt-IdNr. ausschliesslich zu Zwecken der Besteuerung des innergemeinschaftlichen Erwerbs erteilt. Sie sind somit nicht berechtigt, Bestätigungsanfragen zu stellen.'
        ],
        208 => [
            self::MAPPED_CODE => 97,
            self::VALID => null,
            self::MESSAGGE => 'Für die von Ihnen angefragte USt-IdNr. läuft gerade eine Anfrage von einem anderen Nutzer. Eine Bearbeitung ist daher nicht möglich. Bitte versuchen Sie es später noch einmal.'
        ],
        209 => [
            self::MAPPED_CODE => 94, 
            self::VALID => false,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist ungültig. Sie entspricht nicht dem Aufbau der für diesen EU-Mitgliedstaat gilt. ( Aufbau der USt-IdNr. aller EU-Länder)'
        ],
        210 => [
            self::MAPPED_CODE => 94,
            self::VALID => false,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist ungültig. Sie entspricht nicht den Prüfziffernregeln die für diesen EU-Mitgliedstaat gelten.'
        ],
        211 => [
            self::MAPPED_CODE => 94,
            self::VALID => false,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist ungültig. Sie enthält unzulässige Zeichen (wie z.B. Leerzeichen oder Punkt oder Bindestrich usw.).'
        ],
        212 => [
            self::MAPPED_CODE => 8,
            self::VALID => false,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist ungültig. Sie enthält ein unzulässiges Länderkennzeichen.'
        ],
        213 => [
            self::MAPPED_CODE => 1,
            self::VALID => null,
            self::MESSAGGE => 'Die Abfrage einer deutschen USt-IdNr. ist nicht möglich.'
        ],
        214 => [
            self::MAPPED_CODE => 1,
            self::VALID => null,
            self::MESSAGGE => 'Ihre deutsche USt-IdNr. ist fehlerhaft. Sie beginnt mit "DE" gefolgt von 9 Ziffern.'
        ],
        215 => [
            self::MAPPED_CODE => 1,
            self::VALID => null,
            self::MESSAGGE => "Ihre Anfrage enthält nicht alle notwendigen Angaben für eine einfache Bestätigungsanfrage (Ihre deutsche USt-IdNr. und die ausl. USt-IdNr.).\n"
                            . 'Ihre Anfrage kann deshalb nicht bearbeitet werden.'
        ],
        216 => [
            self::MAPPED_CODE => 1,
            self::VALID => true,
            self::MESSAGGE => "Ihre Anfrage enthält nicht alle notwendigen Angaben für eine qualifizierte Bestätigungsanfrage (Ihre deutsche USt-IdNr., die ausl. USt-IdNr., Firmenname einschl. Rechtsform und Ort)."
                            . 'Es wurde eine einfache Bestätigungsanfrage durchgeführt mit folgenden Ergebnis:'
                            . 'Die angefragte USt-IdNr. ist gültig.'
        ],
        217 => [
            self::MAPPED_CODE => 0,
            self::VALID => null,
            self::MESSAGGE => 'Bei der Verarbeitung der Daten aus dem angefragten EU-Mitgliedstaat ist ein Fehler aufgetreten. Ihre Anfrage kann deshalb nicht bearbeitet werden.'
        ],
        218 => [
            self::MAPPED_CODE => 1,
            self::VALID => true,
            self::MESSAGGE => "Eine qualifizierte Bestätigung ist zur Zeit nicht möglich. Es wurde eine einfache Bestätigungsanfrage mit folgendem Ergebnis durchgeführt:\n"
                             .  'Die angefragte USt-IdNr. ist gültig.'
        ],
        219 => [
            self::MAPPED_CODE => 1,
            self::VALID => true,
            self::MESSAGGE => "Bei der Durchführung der qualifizierten Bestätigungsanfrage ist ein Fehler aufgetreten. Es wurde eine einfache Bestätigungsanfrage mit folgendem Ergebnis durchgeführt:\n"
                            . 'Die angefragte USt-IdNr. ist gültig.'
        ],                    
        220 => [
            self::MAPPED_CODE => 1,
            self::VALID => null,
            self::MESSAGGE => 'Bei der Anforderung der amtlichen Bestätigungsmitteilung ist ein Fehler aufgetreten. Sie werden kein Schreiben erhalten.'
        ],
        self::ERROR_CODE_INVALID_REQUEST_DATA => [
            self::MAPPED_CODE => 1,
            self::VALID => null,
            self::MESSAGGE => 'Die Anfragedaten enthalten nicht alle notwendigen Parameter oder einen ungültigen Datentyp. Weitere Informationen erhalten Sie bei den Hinweisen zum Schnittstelle - Aufruf.'
        ],
        223 => [
            self::MAPPED_CODE => 1,
            self::VALID => true,
            self::MESSAGGE => 'Die angefragte USt-IdNr. ist gültig. Die Druckfunktion steht nicht mehr zur Verfügung, da der Nachweis gem. UStAE zu § 18e.1 zu führen ist.'
        ],
        self::ERROR_CODE_SERVICE_NOT_AVAILABLE => [
            self::MAPPED_CODE => 95,
            self::VALID => null,
            self::MESSAGGE => 'Eine Bearbeitung Ihrer Anfrage ist zurzeit nicht möglich. Bitte versuchen Sie es später noch einmal.'
        ],
        self::ERROR_CODE_UNKNOWN => [
            self::MAPPED_CODE => 1,
            self::VALID => null,
            self::MESSAGGE => 'An unknown error has occurred.'
        ]       
    ];
    
    public static function isValid(?int $code): ?bool
    {        
        if (static::isErrorNumberExist($code)) {
           
            return static::$messages[$code][static::VALID];
        }
        
        return null;
    }
    
    public static function isErrorNumberExist(?int $code): bool
    {
        return isset(static::$messages[$code]);
    }
    
    public static function getMessage(?int $code): ?string
    {
        if (static::isErrorNumberExist($code)) {
        
            return static::$messages[$code][static::MESSAGGE];
            
        } elseif(is_null($code)) {
            
            return null;
        }
        
        return static::$messages[static::ERROR_CODE_UNKNOWN][static::MESSAGGE];
    }
    
    public static function getMappedErrorCode(?int $code): ?int
    {       
        if (static::isErrorNumberExist($code)) {
            return static::$messages[$code][static::MAPPED_CODE];
            
        } elseif(is_null($code)) {
            
            return null;
        }
        
        return static::$messages[static::ERROR_CODE_UNKNOWN][static::MAPPED_CODE];
    }
    
    public static function getAddressMessage(?string $char) :?string
    {
        if (array_key_exists($char, static::$addressMessage)) {
       
            return static::$addressMessage[$char][static::MESSAGGE];            
        }
        
        return null;
    }
    
    public static function isAddressValid(?string $char): ?bool
    {
        if (array_key_exists($char, static::$addressMessage)) {
            
            return static::$addressMessage[$char][static::VALID];
        }
        
        return null;
    }
}
