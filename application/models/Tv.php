<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 03.12.2018
 * Time: 21:54
 */

namespace Acme\models;


use Acme\core\IModel;

class TV implements IModel
{
    function find($id)
    {
        return  "Find TV with param $id";
    }

    function all()
    {
    	return  "Show all TV's";
    }
}