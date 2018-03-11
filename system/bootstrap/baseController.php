<?php
namespace Rian\HMVC;

class baseController {
    protected $app;
    protected $modulesClass;
    protected $moduleName="EMPTY-MODULE";
    protected $modules;
    protected $service;
    public function __construct($c) {
        $this->modules = new \stdClass();
        $this->app = $c;
        $this->modulesClass = new Modules($this->app);
        $this->_loadModal($c);
    }

    private function _loadModal($c){
        $modulePath = $c->get('settings')['hmvc']['modulePath'];
        $file = $modulePath.$this->moduleName.'/'.$this->moduleName."_service.php";
        if(file_exists($file)){
            require_once $modulePath.$this->moduleName.'/'.$this->moduleName."_service.php";
            $nm = $this->moduleName."_service";
            $this->service = new $nm($c);
        }
    }

    protected function loadView($module,$view,$data=array()) {
        return $this->modulesClass->loadView($module,$view,$data);
    }

    protected function loadClass($modul, $class){
        $modulePath = $this->app->get('settings')['hmvc']['modulePath'];
        $file = $modulePath.$modul.'/'.$class.".php";
        if(file_exists($file)){
            require_once $file;
            $n =strtolower($class);
            $this->modules->$n = new $class($this->app);
        }
    }

}