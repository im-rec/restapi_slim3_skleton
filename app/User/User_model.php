<?php
use \Rian\HMVC\baseModel;

class User_model extends baseModel {

    function __construct($c) {
        parent::__construct($c);
    }

    function get_user_id($id){
        $query = $this->app->dbberrybenka->prepare("SELECT * FROM users WHERE user_id=:id");
        $query->bindParam("id", $id);

        try{
	        $query->execute();
	        return $query->fetchAll();
	    }catch(\PDOExeption $e){
	        // handle exception
	    }
    }
}