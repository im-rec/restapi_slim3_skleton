<?php
use \Rian\HMVC\Modules;
use \Rian\HMVC\baseController;

class Uid extends baseController {

	protected $moduleName ="Uid";
    protected $modules;

    function __construct($c) {
        parent::__construct($c);
        $this->modules = new Modules($c);
    }

    function data_uid($request, $response, $args){
        //contoh call Service
        $get_uid = $this->service->get_uid("BB-0000000001");
        $token = $this->app->jwtlib->generateToken(1);

        return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['code'=>200, 'data'=>$get_uid, 'token'=>$token]));
    }

    function data_uid_array(){
        //contoh call Service
        $get_uid = $this->service->get_uid("BB-0000000001");

        return $get_uid;

    }

}