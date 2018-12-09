<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 29.11.2018
 * Time: 0:55
 */

namespace Acme\core;


/**
 * Class Request
 * @package Acme\core
 */
class Request
{
    /**
     * @return string
     */
    static function url():string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     */
    static function method():string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

}