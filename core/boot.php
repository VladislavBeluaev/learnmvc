<?php
use Acme\core\{Container,Application};

$container = Container::getInstance();
//$container->compose('/',\Acme\testInterfaces\IMyclass::class);
/*function (\Acme\core\IView $view){
    return $view->make('pages.index',['all'=>$this->repository->all()]);
}*/
//\Acme\testInterfaces\IMyclass::class
(new Application($container,'config'))->run();
//$result = $container->filterContainer('object');
//var_dump($result);
/*try{
    $reflectionFunction = new ReflectionFunction($container->get('viewsWithComposer')['/']);
    $reflectionFunctionParams = $reflectionFunction->getParameters();
    foreach ($reflectionFunctionParams as $key=>$param)
    {
        if(!is_null($param->getClass()))
        {
            $instance = array_filter($result, function ($value) use ($param) {
                $class = $param->getClass()->getName();
                return $value instanceof $class;
            });
            if (empty($instance)) throw new Exception("This class $param does not bound in container");
            array_splice($reflectionFunctionParams, $key, 1, $instance);
        }
    }
    return $reflectionFunction->invokeArgs($reflectionFunctionParams);

}
catch (Exception $exception)
{
    echo  $exception->getMessage();
}*/
/*$result = $container->filterContainer('object');
var_dump($result);

try{
    $reflectionClass = new \ReflectionClass(Acme\views\composers\IndexComposer::class);
    if ($reflectionClass->hasMethod('__construct')) {
        $controllerRefConstruct = $reflectionClass->getMethod('__construct');
        $controllerRefConstructParams = $controllerRefConstruct->getParameters();
        var_dump($controllerRefConstructParams);
        foreach ($controllerRefConstructParams as $key => $param) {
            if (!is_null($param->getClass())) {
                $instance = array_filter($result, function ($value) use ($param) {
                    $class = $param->getClass()->getName();
                    return $value instanceof $class;
                });
                if (empty($instance)) throw new Exception("This class $param does not bound in container");
                array_splice($controllerRefConstructParams, $key, 1, $instance);
            }
        }
        var_dump($controllerRefConstructParams);
        $reflectionInstance = $reflectionClass->newInstanceArgs($controllerRefConstructParams);
        return $reflectionClass->getMethod('compose')->invoke($reflectionInstance,$container->get('IView'));
    }
}
catch (Exception $e)
{
    echo $e->getMessage();
}*/
    //$objectArgsToConstruct =