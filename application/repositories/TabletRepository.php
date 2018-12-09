<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 03.12.2018
 * Time: 21:51
 */

namespace Acme\repositories;


use Acme\core\Repository;
use Acme\models\Tablet;

class TabletRepository implements Repository
{
    protected $tablet;
    function __construct(Tablet $tablet)
    {
        $this->tablet = $tablet;
    }

    function all()
    {
        return $this->tablet->all();
    }

    function find($id)
    {
        return $this->tablet->find($id);
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