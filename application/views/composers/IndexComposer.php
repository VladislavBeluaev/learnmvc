<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 08.12.2018
 * Time: 20:21
 */

namespace Acme\views\composers;


use Acme\core\IComposer;
use Acme\core\IView;
use Acme\repositories\NoteRepository;
use Acme\testClasses\MyClass;
use Acme\testInterfaces\IMyclass;

class IndexComposer implements IComposer
{
    protected $repository;
    protected $str;

    function __construct(IMyclass $repository)
    {
       $this->repository = $repository;
    }

    function compose(IView $view)
    {
        $users = ['vlad'=>'belkin','ira'=>'sedkova'];
        return $view->make('pages.index',['all'=>$this->repository->showData(),'users'=>$users]);
    }

}