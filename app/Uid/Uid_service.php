<?php
use \Rian\HMVC\baseService;

class Uid_service extends baseService {

	protected $moduleName ="Uid";

    function __construct($c) {
        parent::__construct($c);
    }

    function get_uid($uid){
        $data_uid = $this->model->get_uid($uid);

        return $data_uid;
    }
}