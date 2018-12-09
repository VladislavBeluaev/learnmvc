<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 30.11.2018
 * Time: 23:42
 */

namespace Acme\testClasses;
use Acme\testInterfaces\IAnother;


class AnotherClass implements IAnother
{
    function getData()
    {
        return  "Hello world!!";
    }
}