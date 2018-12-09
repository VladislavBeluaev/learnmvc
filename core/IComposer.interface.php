<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 08.12.2018
 * Time: 20:18
 */

namespace Acme\core;


interface IComposer
{
    function compose(IView $view);
}