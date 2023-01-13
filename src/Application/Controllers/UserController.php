<?php

namespace Irpcpro\TeleLink\Application\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Phpass\Hash;
use Irpcpro\TeleLink\Application\Models\Users\Users;

class UserController extends Controller {

    // login user with username & password
    public function login()
    {
        // get fields
        $username = htmlspecialchars($this->getBody()->username ?? '');
        $password = htmlspecialchars($this->getBody()->password ?? '');

        // validate input
        if($username == '' || $password == ''){
            $this->sendOutput([
                'message' => 'Username and password are required.',
                'status' => false,
                'data' => [],
            ], 400);
        }

        // user model
        $modelUser = new Users();
        $sql = "SELECT * FROM $modelUser->table_name WHERE username = '$username' LIMIT 0,1";
        $result = $modelUser->select($sql);

        // if user found
        if(!empty($result)){
            // check hashed password
            $result = $result[0];
            $phpassHash = new Hash();

            // check password
            if($phpassHash->checkPassword($password, $result['password'])){
                // create token
                $secret_key = SITE_SECRET_KEY;
                $issuer_claim = "THE_ISSUER";
                $audience_claim = "THE_AUDIENCE";
                $issuedat_claim = time();
                $notbefore_claim = $issuedat_claim;
                $expire_claim = $issuedat_claim + TOKEN_EXPIRATION_TIME;
                $token = [
                    "iss" => $issuer_claim,
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => [
                        "id" => $result['user_id'],
                        "username" => $result['username'],
                    ]
                ];
                $jwt = JWT::encode($token, $secret_key, 'HS256');
                $this->sendOutput([
                    'message' => 'login successful.',
                    'status' => true,
                    'data' => [
                        'token' => $jwt
                    ]
                ]);

            }else{
                $this->sendOutput([
                    'message' => 'Username or password is wrong.',
                    'status' => false,
                    'data' => [],
                ]);
            }
        }else{
            $this->sendOutput([
                'message' => 'Username or password is wrong.',
                'status' => false,
                'data' => [],
            ]);
        }
    }

    // check authentication
    public function AuthCheck($returnBoolean = true)
    {
        // get authentication token
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if($authHeader){
            // separate token with Bearer
            $arr = explode(" ", $authHeader);
            if(isset($arr[1])){
                // get second part of token
                $jwt = $arr[1];
                try {
                    // decode token
                    $jwt = JWT::decode($jwt, new Key(SITE_SECRET_KEY, 'HS256'));
                    return $returnBoolean
                        ? true
                        : [
                            'message' => 'login successful.',
                            'status' => true,
                            'data' => $jwt,
                            'status_code' => 200,
                        ];
                }catch (\Exception $e){
                    error_log($e->getMessage());
                    return $returnBoolean
                        ? false
                        : [
                            'message' => $e->getMessage(),
                            'status' => false,
                            'data' => [],
                            'status_code' => 401,
                        ];
                }
            }else{
                return $returnBoolean
                    ? false
                    : [
                        'message' => 'Error in authentication.',
                        'status' => false,
                        'data' => [],
                        'status_code' => 400,
                    ];
            }
        }else{
            return $returnBoolean
                ? false
                : [
                    'message' => 'Error in authentication.',
                    'status' => false,
                    'data' => [],
                    'status_code' => 400,
                ];
        }
    }

}
