<?php

namespace Irpcpro\TeleLink\Application\Middleware;

use Pure\Routing\Middleware as routeMiddleware;

class Middleware extends routeMiddleware {

    public function handle(){}

    // send output to client
    protected function sendOutput($data, $statusCode = 200, $httpHeaders = [])
    {
        sendResponse($data, $statusCode = 200, $httpHeaders = []);
    }

}

