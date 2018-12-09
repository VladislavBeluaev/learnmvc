<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 01.12.2018
 * Time: 21:50
 */
namespace Acme\core;

use Acme\traits\Reflection;
/**
 * Class PrototypeRoutes
 * @package Acme\core
 */
class PrototypeRoutes
{
    use Reflection;
    /**
     * @var
     */
    private static $routeInstance;
    /**
     * @var array
     */
    private $prototypeRoutes;
    /**
     * @var string
     */
    //private $parameterSearchPattern;
    /**
     * PrototypeRoutes constructor.
     */
    private function __construct()
    {
        $this->prototypeRoutes = array(
            "GET" => [],
            "POST" => []
        );
        //$this->parameterSearchPattern = '/[a-z].*({\w+\??})/iU';
    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     * @param string $routesFile
     * @return PrototypeRoutes
     * @throws \Exception
     */
    static function load(string $routesFile): PrototypeRoutes
    {
        if (!file_exists($routesFile)) throw new \Exception("Route file not found");
        if (!is_null(self::$routeInstance)) return self::$routeInstance;
        $router = self::$routeInstance = new self();
        require_once $routesFile;
        return $router;
    }

    /**
     * @param string $url
     * @param mixed $controller
     */
    function get(string $url, $controller)
    {
        $this->prototypeRoutes['GET'][$url] = $controller;
    }

    /**
     * @param string $url
     * @param string $controller
     */
    function post(string $url, string $controller)
    {
        $this->prototypeRoutes['POST'][$url] = $controller;
    }

    /**
     * @param string $url
     * @param string $requestMethod
     * @return mixed
     * @throws \Exception
     */
    function directTo(string $url, string $requestMethod)
    {
        if (!$findRoute = $this->isRouteExists($url, $requestMethod)) {
            throw new \Exception("This page not found");
        }
        $callActionWith = array_merge(explode('@', $this->prototypeRoutes[$requestMethod][$findRoute]), array($this->getRequestValues($url)));
        return $this->callAction(...$callActionWith);
    }

    /**
     * @param string $url
     * @param string $requestMethod
     * @return string
     */
    protected function isRouteExists(string $url, string $requestMethod)
    {
        $sizeOfUserRequestArray = $this->sizeOfArray($url);
        $userRequestParams = $this->filterUrlArray($url, function ($key) {
            return (!($key & 1));
        });
        foreach (array_keys($this->prototypeRoutes[$requestMethod]) as $prototypeRoute) {
            $sizeOfPrototypeRouteArray = $this->sizeOfArray($prototypeRoute);
            $prototypeRequestParams = $this->filterUrlArray($prototypeRoute, function ($key) {
                return (!($key & 1));
            });
            if ($userRequestParams === $prototypeRequestParams && $sizeOfPrototypeRouteArray == $sizeOfUserRequestArray) {
                return $prototypeRoute;
            }
        }
        return '';
    }

    /**
     * @param $controller
     * @param $action
     * @param array $actionParams
     * @return mixed
     * @throws \ReflectionException
     */
    protected function callAction($controller, $action, $actionParams = [])
    {
        $controllerClass = "Acme\\controllers\\" . $controller;
        return $this->
        reflectionClass($controllerClass,'replaceClassNameWithImplementation',IController::class,$action,$actionParams);
    }


    /**
     * @param string $url
     * @return array
     */
    protected function getRequestValues(string $url/*,string $requestMethod*/): array
    {
        return array_filter(explode('/', trim($url, '/')), function ($key) {
            return ($key & 1);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @param string $request
     * @return int
     */
    protected function sizeOfArray(string $request): int
    {
        return count(explode('/', trim($request, '/')));
    }

    /**
     * @param string $url
     * @param callable $callback
     * @param string $stringDelimiter
     * @return array
     */
    protected function filterUrlArray(string $url, callable $callback, $stringDelimiter = '/'): array
    {
        return array_filter(explode($stringDelimiter, trim($url, $stringDelimiter)), $callback, ARRAY_FILTER_USE_KEY);
    }

    protected function replaceClassNameWithImplementation($reflectionMethodsParams)
    {
        $objects = [];
        foreach ($reflectionMethodsParams as $param) {
            if (!is_null($param->getClass())) {
                try {
                    $objects[] = $this->getInstance($param, $this->shortClassName);
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());

                }

            }
        }
        return $objects;
    }

    protected function getInstance($instance, $context)
    {
        $instanceName = $instance->getClass()->getShortName();
        try {
            $instance = Container::getInstance()->get($instanceName);
            return $instance;
        } catch (\Exception $e) {
            try {
                $instance = Container::getInstance()->get($context);
                if (!isset($instance[$instanceName])) {
                    throw new \Exception("Wrong class $instance for DI in $context");
                }
                return $instance[$instanceName];
            } catch (\Exception $e) {
                throw new \Exception("Wrong class $instance for DI in $context");
            }
        }

    }
}