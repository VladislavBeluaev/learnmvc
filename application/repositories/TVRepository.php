<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 03.12.2018
 * Time: 21:51
 */

namespace Acme\repositories;


use Acme\core\Repository;
use Acme\models\TV;

class TVRepository implements Repository
{
    protected $tv;
    function __construct(TV $tv)
    {
        $this->tv = $tv;
    }

    function all()
    {
        return $this->tv->all();
    }

    function find($id)
    {
        return $this->tv->find($id);
    }

    function update($id)
    {
        // TODO: Implement update() method.
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
    }

}