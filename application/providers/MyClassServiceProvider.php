<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 02.12.2018
 * Time: 0:56
 */

namespace Acme\providers;

use Acme\core\ServiceProvider;
use Acme\testInterfaces\{IMyclass};
use Acme\testClasses\{MyClass,AnotherClass};

/**
 * Class MyClassServiceProvider
 * @package Acme\providers
 */
class MyClassServiceProvider extends ServiceProvider
{
    /**
     *return MyClass
     */
    function register()
    {
        $this->container->bind(IMyclass::class,function (){
            $anotherClass = $this->container->make(AnotherClass::class);
            return new MyClass($anotherClass,'hello');
        });
    }
    function boot(){}

}