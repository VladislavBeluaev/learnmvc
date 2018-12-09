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
class DesktopPcController implements IController
{
    protected $desktopPcRepository;
    function __construct(Repository $repository)
    {
        $this->desktopPcRepository = $repository;
    }

    /**
     *
     */
    function index()
    {
        echo $this->desktopPcRepository->all();
    }
    /**
     * @param $pcId
     */
    function showPC($pcId)
    {
        echo $this->desktopPcRepository->find($pcId);
    }

}