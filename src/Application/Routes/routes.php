<?php

use Pure\Routing\Router;
use Irpcpro\TeleLink\Application\Middleware\AuthMiddleware;

// get route
$router = new Router();


/* ************************************************ APIs ************************************************ */
// LINKS
$router->post('/api/v1/shortener/create', "Irpcpro\TeleLink\Application\Controllers\LinkController@create")->middleware(AuthMiddleware::class);
$router->get('/api/v1/shortener/get-all', "Irpcpro\TeleLink\Application\Controllers\LinkController@getAll")->middleware(AuthMiddleware::class);
$router->put('/api/v1/shortener/edit', "Irpcpro\TeleLink\Application\Controllers\LinkController@edit")->middleware(AuthMiddleware::class);
$router->delete('/api/v1/shortener/delete/$linkID', "Irpcpro\TeleLink\Application\Controllers\LinkController@delete")->middleware(AuthMiddleware::class);

// USER
$router->post('/api/v1/user/login', "Irpcpro\TeleLink\Application\Controllers\UserController@login");


/* ************************************************ WEB ************************************************ */
// main route site
$router->get('/', function(){ echo "<h2>hello,<br/> for create database, run \"composer run-script sql-creator\"</h2>"; });

// redirect route
$router->get('/'.LINK_SHORTENER_PREFIX.'/$suffix', "Irpcpro\TeleLink\Application\Controllers\LinkController@redirect");


// dispatch routes
try {
    $dispatchRoute = $router->dispatch();
    if(!$dispatchRoute){
        if(isRequestContentTypeJson()){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode('route not found');
            exit;
        }else{
            echo '<h1>Page not found</h1>';
            exit;
        }
    }
} catch (\Exception $e) {
    throw new \Exception($e->getMessage());
}
