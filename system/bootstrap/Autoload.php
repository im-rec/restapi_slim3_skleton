<?php
namespace Rian\HMVC;

if (!defined('DS')) {
    define("DS",DIRECTORY_SEPARATOR);
}

require_once (__DIR__."/modules.php");
require_once (__DIR__."/baseModel.php");
require_once (__DIR__."/baseService.php");
require_once (__DIR__."/baseController.php");


class Autoload {
    protected $app;
    protected $c;
    protected $modulesLocations;
    protected $modules;
    function __construct($app){
        $this->app = $app;
        $this->c = $this->app->getContainer();
        $this->_check();
        $this->init($this->app);
    }

    private function _check(){

        if(!isset($this->c->get('settings')['hmvc']['modulePath'])){
            die("Please set Module Path ['hmvc']['modulePath'] at app container settings");
        }
    }

    public function init($app){
        $mdl = new Modules($this->c);
        $this->modulesLocations = $mdl->getLocations();

        ob_start();
        foreach ($this->modulesLocations as $module) {
            if(file_exists($module->Path.$module->Controller)){
                require $module->Path.$module->Controller;
            }
        }
        foreach ($this->modulesLocations as $module) {
           if(file_exists($module->Path.$module->Routes)){
                include_once $module->Path.$module->Routes;
            }
        }
        return ob_get_clean();
    }

}
