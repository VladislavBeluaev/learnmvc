<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 03.12.2018
 * Time: 21:54
 */

namespace Acme\models;


use Acme\core\IModel;

class DesctopPc implements IModel
{
    function find($id)
    {
        return  "Find desctop with param $id";
    }

    function all()
    {
    	return  "Show all DesctopPc's";
    }
}