<?php
use \Firebase\JWT\JWT;

class Auth {

public static function signToken($user)
{
  $key = "secretkey";

  $payload = ['user_id' => $user['user_id']];

  $jwt = JWT::encode($payload, $key);

  return $jwt;
}

public static function verifyToken()
{
   $headers = apache_request_headers();

  if(!isset($headers['Authorization'])) {
  	return false;
  }
  else {

    $token = split(" ", $headers['Authorization'])[1];

        $key = "secretkey";
        try{
          return JWT::decode($token, $key, array('HS256'));
        }
        catch (\Exception $e) {
          return false;
      }
  }
}

public static function decodeToken($token)
{
      $key = "secretkey";
      try{
        return JWT::decode($token, $key, array('HS256'));
      }
      catch (\Exception $e) {
        return false;
    }
}


}
