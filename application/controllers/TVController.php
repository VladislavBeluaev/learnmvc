<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 02.12.2018
 * Time: 3:12
 */

namespace Acme\controllers;


use Acme\core\IController;
use Acme\core\Repository;


/**
 * Class NotebookController
 * @package Acme\controllers
 * @implements IController
 */
class TVController implements IController
{
    protected $tvRepository;
    function __construct(Repository $repository)
    {
        $this->tvRepository = $repository;
    }

    /**
     *
     */
    function index()
    {
        echo $this->tvRepository->all();
    }
    /**
     * @param $tvId
     */
    function showTV($tvId)
    {
        echo $this->tvRepository->find($tvId);
    }

}