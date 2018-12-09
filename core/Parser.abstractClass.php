<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 02.12.2018
 * Time: 16:01
 */

namespace Acme\core;


abstract class Parser
{
    protected $resource;

    /**
     * Parser constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    abstract function run();
}