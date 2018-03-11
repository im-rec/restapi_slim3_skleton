<?php
namespace Rian\HMVC;

class Modules {
    protected $app;
    protected $modulePath;

    public function __construct($c) {
        $this->app = $c;
        $this->modulePath = $c->get('settings')['hmvc']['modulePath'];
    }

    public function getLocations() {
        $modules = $this->dirToArray($this->modulePath);
        foreach ($modules as $module=>$contents) {
            $modules[$module] = (object) array("Path"=>"","Controller"=>"","Service"=>"","Model"=>"","Views"=>"","ModelName"=>"","ServiceName"=>"","Routes"=>"");
            $modules[$module]->Name = $module;
            $modules[$module]->Path = $this->modulePath.$module.DS;
            $modules[$module]->Controller = $module.".php";
            $modules[$module]->Service = $module."_service.php";
            $modules[$module]->Model = $module."_model.php";
            $modules[$module]->Routes = "routes.php";
            $modules[$module]->ModelName = $module."_model";
            $modules[$module]->ServiceName = $module."_service";

            $tempViews=Array();
            if(!empty($contents['Views'])){
                foreach ($contents['Views'] as $view) {
                    $tempViews[]=$view;
                }
                $modules[$module]->Views=(object)$tempViews;
            }
        }
        return $modules;
    }

    public function loadView($module,$view,$data=array("success"=>false)) {
        $path = $this->modulePath.$module.DS.'views'.DS.$view.'.php';
        if(file_exists($path)){
            $data = (is_array($data) && !empty($data)) ? $data : array('success'=>true);
            foreach ($data as $key => $value) {
                $$key=$value;
            }
            ob_start();
            include($path);
            return ob_get_clean();
        }
    }

    private function dirToArray($dir) {
        $ignore = array('.','..','.DS_Store','index.html','.htaccess','modules.php',
            '_core','hmvc','Model.php','Controller.php','routes.php','autoload.php');
        $contents = array();
        foreach (scandir($dir) as $node) {
            if(in_array($node,$ignore)) continue;
            if($node)
                if (is_dir($dir . DIRECTORY_SEPARATOR . $node)) {
                    $contents[$node] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $node);
                } else {
                    $contents[] = $node;
                }
        }

        return $contents;
    }
}