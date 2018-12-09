<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 08.12.2018
 * Time: 16:02
 */

namespace Acme\views;


use Acme\core\Container;
use Acme\core\IView;

class View implements IView
{
    function make($view, $data = [])
    {
        if(!empty(extract($data)))
            extract($data);
        $realPathToVIew = str_replace('.','/',$view);
        return require_once Container::getInstance()->get('views_path').$realPathToVIew.".tmpl.php";
    }

    function view($view)
    {
        // TODO: Implement view() method.
    }

    function with($nameToView, $dataName)
    {
        // TODO: Implement with() method.
    }

    function share($key, $value)
    {
        // TODO: Implement share() method.
    }

    function composer($view, $viewComposer)
    {
        Container::getInstance()->compose($view,$viewComposer);
    }

    function exists($view)
    {
        // TODO: Implement exists() method.
    }

}