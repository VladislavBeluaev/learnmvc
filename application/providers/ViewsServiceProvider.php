<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 08.12.2018
 * Time: 17:44
 */

namespace Acme\providers;


use Acme\core\IView;
use Acme\core\ServiceProvider;
use Acme\testClasses\MyClass;
use Acme\views\composers\IndexComposer;
use Acme\views\View;

class ViewsServiceProvider extends ServiceProvider
{
    function register()
    {
        $this->container->bind(IView::class,View::class);
    }
    function boot(){

        $this->container->get('IView')->composer('/',IndexComposer::class);
        /*$users = ['vlad'=>'belkin','ira'=>'sedkova'];
        $this->container->compose('/',function (View $view) use ($users){
            return $view->make('pages.index',['all'=>"Good",'users'=>$users]);
        });*/
    }

}