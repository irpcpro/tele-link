<?php

namespace Irpcpro\TeleLink\Application\Middleware;

use Irpcpro\TeleLink\Application\Controllers\UserController;

class AuthMiddleware extends Middleware {

    // if token is invalid, stop to access route
    public function handle(){
        $userModel = new UserController();
        $status = $userModel->AuthCheck(false);
        $requestJson = isRequestContentTypeJson();

        // return result
        if($status['status']){
            return $status;
        }else{
            if($requestJson){
                $this->sendOutput($status);
            }else{
                http_response_code($status['status_code']);
                header("HTTP/1.1 401 Unauthorized");
                echo '<h1>'.$status['message'].'</h1>';
                exit;
            }
        }
    }

}

