<?php 
/**
 * Route assignment 
 * PHP version 8.2
 * 
 * @category Routes
 * @package  Of2
 * @author   Orcun Candan <orcuncandan89@gmail.com>
 * @license  https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt MIT
 * @link     https://github.com/orcnd
 */

use Src\Core\Router;

Router::set(
    '/', 'GET', function () {
        echo 'Hello World';
    }
);

Router::set(
    '/parameter/:first/:second', 'GET', function ($first, $second) {
        echo $first . ' - ' .$second ;
    }
);