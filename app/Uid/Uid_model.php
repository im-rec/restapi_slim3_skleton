<?php
use \Rian\HMVC\baseModel;

class Uid_model extends baseModel {

    function __construct($c) {
        parent::__construct($c);
    }

    function get_uid($uid){
        $query = $this->app->dbwms->prepare("SELECT * FROM uid WHERE uid=:uid");
        $query->bindParam("uid", $uid);

        try{
	        $query->execute();
	        return $query->fetchAll();
	    }catch(\PDOExeption $e){
	        // handle exception
	    }
    }
}