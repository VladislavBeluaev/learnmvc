<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 30.11.2018
 * Time: 23:20
 */

namespace Acme\core;


/**
 * Interface IContainer
 * @package Acme\core
 */
interface IContainer
{
    /**
     * @param string $className
     * @return mixed
     */
    function make(string $className);

    /**
     * @param string $interface
     * @param mixed $className
     * @return mixed
     */
    function bind(string $interface,$className);
    /**
     * @param string $view
     * @param mixed $viewComposerClass
     * @return mixed
     */
    function compose(string $view, $viewComposerClass);

    /**
     * @param string $className
     * @return IContainer
     */
    function when(string $className);

    /**
     * @param string $className
     * @return IContainer
     */
    function need(string $className);

    /**
     * @param mixed $className
     * @return void
     */
    function give($className);

    /**
     * @param string $bindKey
     * @return mixed
     */

    function get($bindKey);

    /**
     * @param string $filter
     * @return mixed
     */
    function filterContainer($filter);
    /**
     * @param mixed $key
     * @param mixed $value
     */
    function set($key,$value);
    /**
     * @param string $className
     * @param string|null $singleton
     * @return mixed
     */
    function singleton(string $className, string $singleton=null);
}