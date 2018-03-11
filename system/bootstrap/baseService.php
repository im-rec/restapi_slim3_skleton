<?php
namespace Rian\HMVC;

class baseService {
    protected $app;
    protected $modulesClass;
    protected $moduleName="EMPTY-MODULE";
    protected $modules;
    protected $model;
    public function __construct($c) {
        $this->modules = new \stdClass();
        $this->app = $c;
        $this->modulesClass = new Modules($this->app);
        $this->_loadModal($c);
    }

    private function _loadModal($c){
        $modulePath = $c->get('settings')['hmvc']['modulePath'];
        $file = $modulePath.$this->moduleName.'/'.$this->moduleName."_model.php";
        if(file_exists($file)){
            require_once $modulePath.$this->moduleName.'/'.$this->moduleName."_model.php";
            $nm = $this->moduleName."_model";
            $this->model = new $nm($c);
        }
    }

}