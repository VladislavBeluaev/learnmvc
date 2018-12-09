<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 29.11.2018
 * Time: 0:15
 */

namespace Acme\core;


/**
 * Class Routes
 * @package Acme\core
 */
class Routes
{
    /**
     * @var
     */
    private static $router;
    /**
     * @var
     */
    private $routes;

    /**
     * Routes constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param string $routesFile
     * @return Routes
     */
    static function load(string $routesFile):Routes
    {
        if (!is_null(Routes::$router)) return self::$router;
        $router = self::$router = new self();
        require_once $routesFile;
        return $router;
    }

    /**
     * @param string $url
     * @param string $controller
     */
    function get(string $url, string $controller)
    {
        $this->routes['GET'][$url] = $controller;
    }

    /**
     * @param string $url
     * @param string $controller
     */
    function post(string $url, string $controller)
    {
        $this->routes['POST'][$url] = $controller;
    }

    /**
     * @param string $url
     * @param string $requestMethod
     * @return mixed
     * @throws \Exception
     */
    function directTo(string $url, string $requestMethod):mixed
    {
        if (!array_key_exists($url, $this->routes[$requestMethod]))
            throw new \Exception("такая страница не найдена");
        $callActionParams = array_merge(explode('@', $this->routes[$requestMethod][$url]), $this->getRequestParams($url));
        return $this->callAction(...$callActionParams);
    }

    /**
     * @param string $controller
     * @param string $action
     * @param array $requestParams
     * @return mixed
     * @throws \ReflectionException
     */
    function callAction(string $controller, string $action, array $requestParams=[]):mixed
    {
        $controllerRef = new \ReflectionClass("Acme\\controllers\\".$controller);
        if(!$controllerRef->implementsInterface('IController')) throw new \ReflectionException("Invalid controller $controller class passed to ReflectionClass.");
        if(!$controllerRef->hasMethod($action)) throw new \ReflectionException("A non-existent method $action called in class $controller.");
        $controllerRefMethod = $controllerRef->getMethod($action);
        $controllerRefInstance = $controllerRef->newInstance();
        return $controllerRefMethod->invokeArgs($controllerRefInstance,$requestParams);
    }

    /**
     * @param string $url
     * @return array
     */
    protected function getRequestParams(string $url):array
    {
        return array_filter(explode('/',trim($url,'/')),function($key){
         return ($key & 1);
        },ARRAY_FILTER_USE_KEY);
    }

    /**
     *
     */
    private function __clone()
    {
    }

}