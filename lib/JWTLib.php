<?php

namespace Lib;

use \Firebase\JWT\JWT as FirebaseJWT;

class JWTLib {
  protected $jwt_secret;
  protected $jwt_alg;

  public function __construct(){
    $this->jwt_secret = getenv("JWT_SECRET");
    $this->jwt_alg = getenv("JWT_ALG");
  }

  public function generateToken($id){
    if($id && $id > 0){
      $issued_at = time();
      $not_before = $issued_at + 0;
      if (intval(getenv("ENV_TEST_POSTMAN")) == 1) {
         $expire_at = null;
      } else {
         $expire_at = $not_before + 600;
      }
      $server_name = getenv("APP_URL");
      $data = array();
      $token_id = base64_encode($id);

      $payload = array(
        "iat" => $issued_at,
        "nbf" => $not_before,
        "exp" => $expire_at,
        "jti" => $token_id,
        "iss" => $server_name,
        "data" => $data
      );

      $result = FirebaseJWT::encode($payload, $this->jwt_secret, $this->jwt_alg);
    } else {
      $result = null;
    }

    return $result;
  }

  public function decodeToken($jwt){
    $result = FirebaseJWT::decode($jwt, $this->jwt_secret, array($this->jwt_alg));
    return $result;
  }
  
}