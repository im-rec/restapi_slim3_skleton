<?php
use \Rian\HMVC\Modules;
use \Rian\HMVC\baseController;

class User extends baseController {

	protected $moduleName ="User";
    protected $modules;
    protected $DI;

    function __construct($c) {
        parent::__construct($c);
        $this->DI = $c;
        $this->modules = new Modules($c);
    }

    function home ($request, $response, $args){
        // contoh call Service
        $get_user = $this->service->get_user(1);

        return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['code'=>200, 'data'=>$get_user]));

    }

    function call_another_controller(){

        $this->loadClass("Uid","Uid");
        $a = $this->modules->uid;

        $data = $a->data_uid_array();

        return $this->DI->get('response')->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['code'=>200, 'data'=>$data]));

    }

    function call_another_service(){

        $this->loadClass("Uid","Uid_service");

        $a = $this->modules->uid_service;

        print_r($a->get_uid("BB-0000000001"));

    }

    function call_another_model(){

        $this->loadClass("Uid","Uid_model");

        $a = $this->modules->uid_model;

        print_r($a->get_uid("BB-0000000001"));

    }

    function call_external_class(){

        /*
        * Parameter
        * @path : Lokasi folder file di dalam folder app
        * @name : Nama file dan nama class harus sama
        */
        $this->loadClass("User/Reference","External_class");

        $a = $this->modules->external_class;

        print_r($a->hore());

    }

    function coba_redis(){

        $item = $this->app->redis->getItem('unique-cache-key');
        if ($item->isHit()) {
            return 'I was previously called at ' . $item->get();
        }else {
            $item->set(time());
            $item->expiresAfter(3600);
            $this->app->redis->save($item);

            return 'I am being called for the first time, I will return results from cache for the next 3600 seconds.';
        }

    }

}