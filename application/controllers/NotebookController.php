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
use Acme\testClasses\MyClass;
use Acme\testInterfaces\IMyclass;

/**
 * Class NotebookController
 * @package Acme\controllers
 * @implements IController
 */
class NotebookController implements IController
{
    protected $noteRepository;
    protected $my;
    function __construct(IMyclass $my,Repository $repository)
    {
        $this->noteRepository = $repository;
        $this->my = $my;
    }

    /**
     *
     */
    function index()
    {
        echo $this->noteRepository->all();
    }
    /**
     * @param $noteId
     * @method showData
     */
    function showNote($noteId)
    {
        echo $this->noteRepository->find($noteId);
        echo $this->my->showData();
    }
    function price($noteId,$price)
    {
        echo $this->showNote($noteId)." with price $price";
    }

}