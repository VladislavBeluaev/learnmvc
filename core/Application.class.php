<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 09.12.2018
 * Time: 0:13
 */

namespace Acme\core;


use Acme\traits\Reflection;

class Application
{
    use Reflection;
    private $iniArray;
    private $container;
    private $app;
    private $providers;
    function __construct(IContainer $container,$dirConfig)
    {
        $this->container = $container;
        $this->app = $this->loadApp("$dirConfig/app.php");
        $this->setIniArray($dirConfig);
    }
    function bootApp()
    {
        $this->providers = $this->app['providers'];
        if (empty($this->providers)) throw new \Exception("There are no boot providers. Check file app.php");
        $this->callProviderMethods('register');
        return $this;
    }
    function bootIniFiles()
    {
        foreach ($this->iniArray as $iniFile){
            $iniArray = parse_ini_file($iniFile,true);
            array_walk(
                $iniArray,
                function($value,$key){
                    if($key=='views_path')
                        $this->container->set($key,$value['path']);
                    else
                        $this->container->set($key,$value);
                });
        }
        return $this;
    }
    function run()
    {
        $this->bootApp()->bootIniFiles()->bootViewComposers();
    }
    function bootViewComposers(){
        $this->callProviderMethods('boot');
        $viewsComposers = $this->container->get('viewsWithComposer');
        if(!empty($viewsComposers))
        {
            foreach ($viewsComposers as $page=>$composer)
            {
                if(Request::url()==$page)
                {
                    if(is_string($composer))
                    {
                        return $this->
                        reflectionClass($composer,'replaceClassNameWithImplementation',IComposer::class,'compose');
                    }
                    return $this->reflectionFunction($composer,'replaceClassNameWithImplementation');

                }
            }
        }
    }
    private function loadApp($filePath){
        if(!file_exists($filePath)) throw new \Exception("Application file not found");
        return require_once $filePath;
    }

    private function callProviderMethods($methodName)
    {
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->providers)) as $provider) {
            $providerInstance = new $provider($this->container);
            if(!method_exists($providerInstance,$methodName)) throw new \Exception("Call to undefined method $methodName");
            $providerInstance->$methodName();
        }
    }

    protected function setIniArray($dir)
    {
        foreach (new \DirectoryIterator($dir) as $files)
        {
            if($files->getExtension()=='ini')
            {
                $this->iniArray[] = $files->getPathname();
            }
        }
    }
    function replaceClassNameWithImplementation($reflectionMethodsParams)
    {
        $objects = $this->container->filterContainer('object');
        foreach ($reflectionMethodsParams as $key => $param) {
            if (!is_null($param->getClass())) {
                $instance = array_filter($objects, function ($value) use ($param) {
                    $class = $param->getClass()->getName();
                    return $value instanceof $class;
                });
                if (empty($instance)) throw new \Exception("This class $param does not bound in container");
                return $instance;
            }
        }
    }
}