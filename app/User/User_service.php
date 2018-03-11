<?php
use \Rian\HMVC\baseService;

class User_service extends baseService {

	protected $moduleName ="User";

    function __construct($c) {
        parent::__construct($c);
    }

    function get_user($id){
        $id_user = $id;
        $data_user = $this->model->get_user_id($id_user);

        return $data_user;
    }
}