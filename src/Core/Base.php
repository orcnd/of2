<?php 

/**
 * Base Operations
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
  * Init Class
  *
  * @category Core
  * @package  Of2
  * @author   orcun candan <orcuncandan89@gmail.com>
  * @tag      Core, Init
  * @license  https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt MIT
  * @link     https://github.com/orcnd
  */
class Base
{
    /**
     * Inits env and database connection
     * 
     * @return void
     */
    public function __construct()
    {
        $this->_env();
        $this->_database();
        $this->_router();
    }

    /**
     * Loads Env file
     *
     * @return void
     */
    private function _env():void 
    {
        $Loader = new \josegonzalez\Dotenv\Loader(__DIR__ . '/../../.env');
        // Parse the .env file
        $Loader->parse();
        // Send the parsed .env file to the $_ENV variable
        $Loader->toEnv();

    }


    /**
     * Loads database connection
     *
     * @return void
     */
    private function _database():void 
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection(
            [
            "driver" => $_ENV['DB_CONNECTION'],
            "host" =>$_ENV['DB_HOST'],
            "port" => $_ENV['DB_PORT'],
            "database" => $_ENV['DB_DATABASE'],
            "username" => $_ENV['DB_USERNAME'],
            "password" => $_ENV['DB_PASSWORD']
            ]
        );
         $capsule->setAsGlobal();
         $capsule->bootEloquent();
    }

    /**
     * Loads Router
     *
     * @return void
     */
    private function _router():void 
    {
        $status = \Src\Core\Router::run(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD']
        );
        if ($status === false) {
            \Src\Helpers\Http::status(404);
        }
    }
}



