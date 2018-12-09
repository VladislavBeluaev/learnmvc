<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 04.12.2018
 * Time: 23:17
 */

namespace Acme\controllers;


use Acme\core\IController;
use Acme\core\IView;

class PageController implements IController
{
    protected $view;
    function __construct(IView $view)
    {
        $this->view =$view;
    }

    function index(){
        /*$users =  ['test'=>'vlad','test2'=>'Ira'];
        return $this->view->make('pages.index',compact('users'));*/
    }
    function login(){}
    function register(){}
    function admin(){}
}