<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 09.12.2018
 * Time: 19:04
 */

namespace Acme\traits;


trait Reflection
{
    protected $class;
    protected $shortClassName;
    protected $method;
    protected $instance;
    function reflectionClass(string $className,$callback,$implementsInterfaces = '',$methodName='',$extraParams=[])
    {
        try {
            $this->class = new \ReflectionClass($className);
            $this->shortClassName = $this->getShortName($className);
            if ($implementsInterfaces!=='') {
                $this->isImplementInterface($implementsInterfaces);
            }
            if ($this->class->hasMethod('__construct')) {
                $this->reflectionConstruct($callback,$extraParams);
            }
            if($methodName!==''){
                $this->hasMethod($methodName);
                return $this->reflectionMethod($callback,$methodName,$extraParams);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return true;
    }
    function reflectionFunction($function,$callback)
    {
        $reflectionFunction = new \ReflectionFunction($function);
        $callParams = call_user_func_array(array($this,$callback),array($reflectionFunction->getParameters()));
        return $reflectionFunction->invokeArgs($callParams);
    }

    function reflectionConstruct($callBack,$extraParams)
    {
        $this->method = $this->class->getMethod('__construct');
        $this->instance =$this->class->newInstanceArgs($this->getCallParams($callBack,$extraParams));
    }

    function reflectionMethod($callBack,$methodName,$extraParams)
    {
        $this->method = $this->class->getMethod($methodName);
        $allParams = [];
        if($this->method->getNumberOfParameters())
        {
            $allParams = $this->getCallParams($callBack,$extraParams);
        }
        return $this->method->invokeArgs($this->instance, $allParams);
    }

    private function isImplementInterface($implementsInterfaces)
    {
        if (!$this->class->implementsInterface($implementsInterfaces)) {
            throw new \ReflectionException("This class $this->shortClassName does not implements $implementsInterfaces");
        }
    }
    private function getCallParams($callBack,$extraParams)
    {
        $instanceParams = call_user_func_array(array($this,$callBack),array($this->getMethodsParams()));
       return array_merge($instanceParams,$extraParams);
    }
    private function hasMethod($methodName)
    {
        if (!$this->class->hasMethod($methodName))
            throw new \ReflectionException("A non-existent method $methodName called in class $this->shortClassName.");
    }

    private function getShortName($name)
    {
        return (new \ReflectionClass($name))->getShortName();
    }

    private function getMethodsParams()
    {
        return $this->method->getParameters();
    }
}