<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 03.12.2018
 * Time: 21:51
 */

namespace Acme\repositories;


use Acme\core\Repository;
use Acme\models\DesctopPc;

class DesctopPcRepository implements Repository
{
    protected $pc;
    function __construct(DesctopPc $pc)
    {
        $this->pc = $pc;
    }

    function all()
    {
        return $this->pc->all();
    }

    function find($id)
    {
        return $this->pc->find($id);
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