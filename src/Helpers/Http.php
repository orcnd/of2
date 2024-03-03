<?php

/**
 * Http Helper
 * PHP version 8.2
 * 
 * @category Helpers
 * @package  Of2
 * @author   Orcun Candan <orcuncandan89@gmail.com>
 * @license  https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt MIT
 * @link     https://github.com/orcnd
 */

namespace Src\Helpers;

/**
 * Http Helper.
 *
 * @category Helpers
 * @package  Of2
 * @author   orcun candan <orcuncandan89@gmail.com>
 * @tag      Helpers,http
 * @license  https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt MIT
 * @link     https://github.com/orcnd
 */

class Http
{

    /**
     * Http Code array
     * 
     * @var array
     */
    private static array $_httpCodes= [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing', // WebDAV; RFC 2518
        103 => 'Early Hints', // RFC 8297
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information', // since HTTP/1.1
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content', // RFC 7233
        207 => 'Multi-Status', // WebDAV; RFC 4918
        208 => 'Already Reported', // WebDAV; RFC 5842
        226 => 'IM Used', // RFC 3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found', // Previously "Moved temporarily"
        303 => 'See Other', // since HTTP/1.1
        304 => 'Not Modified', // RFC 7232
        305 => 'Use Proxy', // since HTTP/1.1
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect', // since HTTP/1.1
        308 => 'Permanent Redirect', // RFC 7538
        400 => 'Bad Request',
        401 => 'Unauthorized', // RFC 7235
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required', // RFC 7235
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed', // RFC 7232
        413 => 'Payload Too Large', // RFC 7231
        414 => 'URI Too Long', // RFC 7231
        415 => 'Unsupported Media Type', // RFC 7231
        416 => 'Range Not Satisfiable', // RFC 7233
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot', // RFC 2324, RFC 7168
        421 => 'Misdirected Request', // RFC 7540
        422 => 'Unprocessable Entity', // WebDAV; RFC 4918
        423 => 'Locked', // WebDAV; RFC 4918
        424 => 'Failed Dependency', // WebDAV; RFC 4918
        425 => 'Too Early', // RFC 8470
        426 => 'Upgrade Required',
        428 => 'Precondition Required', // RFC 6585
        429 => 'Too Many Requests', // RFC 6585
        431 => 'Request Header Fields Too Large', // RFC 6585
        451 => 'Unavailable For Legal Reasons', // RFC 7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates', // RFC 2295
        507 => 'Insufficient Storage', // WebDAV; RFC 4918
        508 => 'Loop Detected', // WebDAV; RFC 5842
        510 => 'Not Extended', // RFC 2774
        511 => 'Network Authentication Required', // RFC 6585
    ];

    /**
     * Sets Csrf Token and returns for ui
     *
     * @return string
     */
    public static function csrf():string
    {

        @session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = self::_createCsrfToken();
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Checks Csrf Token
     *
     * @param string $controlToken token to be checked
     * 
     * @return boolean
     */
    public static function checkCsrfToken(string $controlToken= ''):bool
    {
        $tokenToBe = self::_createCsrfToken();
        if ($controlToken === $tokenToBe) {
            return true;
        }
        return false;
    }

    /**
     * Creates Csrf Token
     *
     * @return string
     */
    private static function _createCsrfToken():string
    {
        return md5(session_id() . 'token');
    }

    /**
     * Creates Http response
     * 
     * @param int    $code    Http code 
     * @param string $message optional message
     * 
     * @return void
     */
    public static function status(int $code, string $message= ''):void
    {
        $header='404 Not Found';
        if (in_array($code, self::$_httpCodes)) {
            $header= self::$_httpCodes[$code];
        }

        header('HTTP/1.0 ' . $header);
        echo $message;
        exit;
    }

    /**
     * Redirects the user 
     *
     * @param string $url url to redirect
     * 
     * @return void
     */
    public static function redirect(string $url='') 
    {
        header('Location: ' . $url);
        exit;
    }


}