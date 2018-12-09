<?php
/**
 * Created by PhpStorm.
 * User: Dragon
 * Date: 04.12.2018
 * Time: 23:02
 */

namespace Acme\providers;


use Acme\controllers\DesktopPcController;
use Acme\controllers\MobileController;
use Acme\controllers\NotebookController;
use Acme\controllers\TabletController;
use Acme\controllers\TVController;
use Acme\core\Repository;
use Acme\core\ServiceProvider;
use Acme\models\DesctopPc;
use Acme\models\Mobile;
use Acme\models\NoteBook;
use Acme\models\Tablet;
use Acme\models\TV;
use Acme\repositories\DesctopPcRepository;
use Acme\repositories\MobileRepository;
use Acme\repositories\NoteRepository;
use Acme\repositories\TabletRepository;
use Acme\repositories\TVRepository;

class ControllerServiceProvider extends ServiceProvider
{
    function register()
    {
        $this->container->when(NotebookController::class)->
        need(Repository::class)->
        give(function(){
            $noteBook = $this->container->make(NoteBook::class);
            return new NoteRepository($noteBook);
        });

        $this->container->when(MobileController::class)->
        need(Repository::class)->
        give(function(){
            $mobile = $this->container->make(Mobile::class);
            return new MobileRepository($mobile);
        });

        $this->container->when(TVController::class)->
        need(Repository::class)->
        give(function(){
            $tv = $this->container->make(TV::class);
            return new TVRepository($tv);
        });

        $this->container->when(DesktopPcController::class)->
        need(Repository::class)->
        give(function(){
            $pc = $this->container->make(DesctopPc::class);
            return new DesctopPcRepository($pc);
        });

        $this->container->when(TabletController::class)->
        need(Repository::class)->
        give(function(){
            $tablet = $this->container->make(Tablet::class);
            return new TabletRepository($tablet);
        });
    }
    function boot(){}

}