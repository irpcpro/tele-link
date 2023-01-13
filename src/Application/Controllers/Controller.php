<?php

namespace Irpcpro\TeleLink\Application\Controllers;

class Controller {

    // get body of request from client
    protected function getBody()
    {
        $body = file_get_contents('php://input');
        json_decode($body);
        if(json_last_error() == JSON_ERROR_NONE){
            return json_decode($body);
        }else{
            return false;
        }
    }

    // send output message to client
    protected function sendOutput($data, $statusCode = 200, $httpHeaders = [])
    {
        sendResponse($data, $statusCode = 200, $httpHeaders = []);
    }

    // get current user from token
    public function current_user()
    {
        $userController = new UserController();
        $currentUser = $userController->AuthCheck(false);
        if($currentUser['status']){
            return [
                'user_id' => $currentUser['data']->data->id,
                'username' => $currentUser['data']->data->username,
            ];
        }else{
            return [];
        }
    }
    
}

