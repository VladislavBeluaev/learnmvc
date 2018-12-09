<?php
use Acme\core\{Routes,Request,PrototypeRoutes};
error_reporting(E_ALL);
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 28.11.2018
 * Time: 22:44
 */
require_once "vendor/autoload.php";
require_once "core/bootstrap.php";
try{
    PrototypeRoutes::load('application/routes.php')->directTo(Request::url(),Request::method());
}
catch (Exception $e)
{
    echo $e->getMessage()."<br>";
    var_dump($e->getTrace());
}