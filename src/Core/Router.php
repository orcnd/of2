<?php

/**
 * Router
 * PHP version 8.2
 * 
 * @category Core
 * @package  Of2
 * @author   Orcun Candan <orcuncandan89@gmail.com>
 * @license  https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt MIT
 * @link     https://github.com/orcnd
 */

namespace Src\Core;

/**
 * Router Class.
 *
 * @category Core
 * @package  Of2
 * @author   orcun candan <orcuncandan89@gmail.com>
 * @tag      Core
 * @license  https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt MIT
 * @link     https://github.com/orcnd
 */
class Router
{

    /**
     * Route Array
     *
     * @var array
     */
    private static array $_routes = [];

    /**
     * Sets Routes
     *
     * @param string         $route    route uri
     * @param string         $method   HTTP method 
     * @param callable|array $callback callback 
     * 
     * @return void
     */
    public static function set(
        string $route,
        string $method,
        callable|array $callback
    ) : void {
        $method = strtoupper(trim($method));

        self::$_routes[] = [
            'route' => $route,
            'method' => $method,
            'callback' => $callback,
        ];
    }

    /**
     * Finds route in set route of list
     *
     * @param string $route  route url string
     * @param string $method http method
     * 
     * @return false|array
     */
    private static function _findRoute(string $route, string $method):false|array
    {
        $params = [];
        $foundRoute = array_filter(
            self::$_routes,
            function ($theRoute) use (&$route,&$method,&$params) {
                //kudos to https://stackoverflow.com/questions/11722711/url-routing-regex-php/11723153#11723153
                // convert urls like '/users/:uid/posts/:pid' to regular expression
                $pattern = "@^" . preg_replace(
                    '/\\\:[a-zA-Z0-9\_\-]+/', 
                    '([a-zA-Z0-9\-\_]+)', preg_quote($theRoute['route'])
                ) . "$@D";
                
                
                // check if the current request matches the expression
                $matches = [];
                $status=($method == $theRoute['method']
                    && preg_match($pattern, $route, $matches));
                
                if ($status===true) {
                    array_shift($matches);
                    $params=$matches;
                }
                return $status;

            }
        );
        $foundRoute=end($foundRoute);
        if ($foundRoute) {
            $foundRoute['params']=$params;
        }
        return $foundRoute;
    }

    /**
     * Runs specific route
     *
     * @param string $route 
     * @param string $method HTTP method
     * 
     * @return boolean
     */
    public static function run(string $route, string $method) : bool
    {
        $route = trim($route);
        $method = strtoupper(trim($method));
        
        $fRoute=self::_findRoute($route, $method);

        if ($fRoute) {
            $csrfRequiredMethods=['POST','PUT'];
            //csrf token check
            if (in_array($method, $csrfRequiredMethods)) {
                if (isset($_SERVER['HTTP_X-CSRF-TOKEN']) 
                    || isset($_POST['_token'])
                ) {
                    $token = isset($_SERVER['HTTP_X-CSRF-TOKEN'])
                        ? $_SERVER['HTTP_X-CSRF-TOKEN']
                        : $_POST['_token'];
                        
                    if (\Src\Helpers\Http::checkCsrfToken($token) === false) {
                        \Src\Helpers\Http::status(400, 'Bad Request Token');
                    }
                }
            }

            // call the callback with the matched positions as params
            $callback=$fRoute['callback'];
            if (is_array($callback) && count($callback) == 2) {
                $controller = new $callback[0]();
                $callback = [$controller, $callback[1]];
            }

            // calling the callback 
            call_user_func_array($callback, $fRoute['params']);
            return true;
        }

        return false; 
    }

   

}