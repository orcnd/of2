<?php 
/**
 * Common Helper functions
 * PHP version 8.2
 * 
 * @category Helpers
 * @package  Of2
 * @author   Orcun Candan <orcuncandan89@gmail.com>
 * @license  https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt MIT
 * @link     https://github.com/orcnd
 */

/**
 * Returns view 
 *
 * @param string $viewName views name
 * @param array  $data     parameters if there is any
 * 
 * @return string
 */
function view(string $viewName, array $data=[]) :string
{
    $blade=new \Jenssegers\Blade\Blade('..\\src\\Views', '..\\cache');
    return $blade->make($viewName, $data)->render();
}


/**
 * Csrf input helper
 *
 * @param boolean $print to print or not
 * 
 * @return string
 */
function csrf(bool $print=true):string
{
    $html=\Src\Helpers\Form::csrfInput();
    if ($print) {
        echo $html;
    }
    return $html;
}