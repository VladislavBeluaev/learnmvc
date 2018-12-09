<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 03.12.2018
 * Time: 21:52
 */

namespace Acme\core;


interface Repository
{
    function all();
    function find($id);
    function update($id);
    function delete($id);
}