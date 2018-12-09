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
class MobileController implements IController
{
    protected $mobileRepository;
    function __construct(Repository $repository)
    {
        $this->mobileRepository = $repository;
    }

    /**
     *
     */
    function index()
    {
        echo $this->mobileRepository->all();
    }
    /**
     * @param $mobileId
     */
    function showMobile($mobileId)
    {
        echo $this->mobileRepository->find($mobileId);
    }

}