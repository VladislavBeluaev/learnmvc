<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 28.11.2018
 * Time: 23:25
 */

namespace Acme\core;


interface IView
{
    function make($view,$data=[]);
    function view($view);
    function with($nameToView,$dataName);
    function share($key,$value);
    function composer($view,$viewComposer);
    function exists($view);
}