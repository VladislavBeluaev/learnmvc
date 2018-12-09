<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 02.12.2018
 * Time: 0:53
 */

namespace Acme\core;


abstract class ServiceProvider
{
    protected $container;
    function __construct(IContainer $container)
    {
        $this->container = $container;
    }
    abstract function register();
    abstract function boot();
}