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
class TabletController implements IController
{
    protected $tabletRepository;
    function __construct(Repository $repository)
    {
        $this->tabletRepository = $repository;
    }

    /**
     *
     */
    function index()
    {
        echo $this->tabletRepository->all();
    }
    /**
     * @param $tabletId
     */
    function showTablet($tabletId)
    {
        echo $this->tabletRepository->find($tabletId);
    }

}