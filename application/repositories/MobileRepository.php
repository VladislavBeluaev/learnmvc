<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 03.12.2018
 * Time: 21:51
 */

namespace Acme\repositories;


use Acme\core\Repository;
use Acme\models\Mobile;

class MobileRepository implements Repository
{
    protected $mobile;
    function __construct(Mobile $mobile)
    {
        $this->mobile = $mobile;
    }

    function all()
    {
        return $this->mobile->all();
    }

    function find($id)
    {
        return $this->mobile->find($id);
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