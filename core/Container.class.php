<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 30.11.2018
 * Time: 23:25
 */

namespace Acme\core;

/**
 * Class Container
 * @package Acme\core
 */
class Container implements IContainer
{
    private static $containerInstance;
    protected $bind;
    protected $views;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): Container
    {
        if (!is_null(static::$containerInstance)) return static::$containerInstance;
        static::$containerInstance = new self();
        return static::$containerInstance;
    }

    function make(string $className)
    {
        return new $className;
    }

    function bind(string $interface,$className)
    {
        $bindKey = $this->shortKey($interface);
        $this->bind[$bindKey] = $this->getInstanceOfClassName($className);
    }
    function compose(string $view, $viewComposerClass)
    {
        $this->bind['viewsWithComposer'][$view] = $viewComposerClass;
    }

    function when(string $className)
    {
        $bindKey = $this->shortKey($className);
        if (!array_key_exists($bindKey, $this->bind)) {
            $this->bind[$bindKey] = 'needToBind';
        }
        return $this;
    }

    function need(string $interface)
    {
        $bindKey = array_search('needToBind', $this->bind);
        if (!$bindKey) throw new \Exception("No context to bind interface");
        $this->bind[$bindKey] = [$this->shortKey($interface) => ''];
        return $this;
    }

    function give($className)
    {
        $instanceOfClassName = $this->getInstanceOfClassName($className);
        $this->setImplementationForInterface($this->bind, $instanceOfClassName);
    }

    function singleton(string $className, string $singleton = null)
    {

    }

    function get($bindKey)
    {
        if (!array_key_exists($bindKey, $this->bind)) throw new \Exception("This $bindKey is not bound in the container.");
        return $this->bind[$bindKey];
    }
    function set($key,$value)
    {
        $this->bind[$key] = $value;
    }

    private function shortKey($interface)
    {
        return (new \ReflectionClass($interface))->getShortName();
    }
    private function getInstanceOfClassName($className){
        return is_callable($className)?call_user_func($className):new $className;
    }
    private function setImplementationForInterface(array &$arr, $className, $searchParam = '')
    {
        foreach ($arr as $key => &$value)
            if (is_array($value)) {
                $this->setImplementationForInterface($value, $className);
            } else
                if ($value == $searchParam) {
                    $value = $className;
                }
    }

    public function getBinds()
    {
        return $this->bind;
    }
    function filterContainer($filter)
    {
        $filterData = [];
        $container = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->bind),\RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($container as $value)
        {
            try{
                if(call_user_func('is_'.$filter,$value))
                {
                    $filterData[] =  $value;
                }
            }
            catch (\Exception $e)
            {
                throw new \Exception("This filter $filter does not exists");
            }
        }
        return $filterData;
    }
}