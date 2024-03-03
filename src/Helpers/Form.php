<?php

/**
 * Form Helper
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
 * Form Helper.
 *
 * @category Helpers
 * @package  Of2
 * @author   orcun candan <orcuncandan89@gmail.com>
 * @tag      Helpers,form
 * @license  https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt MIT
 * @link     https://github.com/orcnd
 */

class Form
{

    /**
     * Creates Csrf input form element
     * 
     * @return string hidden form element that contains csrf token in token name
     */
    public static function csrfInput():string 
    {
        $token=\Src\Helpers\Http::csrf();
        $html= '<input type="hidden" name="_token" value="' . $token . '">';
        return $html;
    }
}