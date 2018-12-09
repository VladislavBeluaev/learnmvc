<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 30.11.2018
 * Time: 23:41
 */

namespace Acme\testClasses;
use Acme\testInterfaces\IMyclass;


/**
 * Class MyClass
 * @package Acme\testClasses
 * @implements IMyclass
 */
class MyClass implements IMyclass
{
    /**
     * @var AnotherClass
     */
    private $dependency;
    /**
     * @var
     */
    private $string;

    /**
     * MyClass constructor.
     * @param AnotherClass $dependency
     * @param $string
     */
    public function __construct(AnotherClass $dependency, $string)
    {
        $this->dependency = $dependency;
        $this->string = $string;
    }

    /**
     * @return string
     */
    function showData()
    {
        return $this->dependency->getData();
    }
}