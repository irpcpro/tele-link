<?php

// create uuid
function generate_uuid() {
    return bin2hex(openssl_random_pseudo_bytes(3));
}

// check if string is url
function checkURL($url){
    $regex = "((https?|ftp)\:\/\/)?";
    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
    $regex .= "(\:[0-9]{2,5})?";
    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";

    return (bool) preg_match("/^$regex$/i", $url);
}

// send response to client
function sendResponse($data, $statusCode = 200, $httpHeaders = []) {
    if (is_array($httpHeaders) && count($httpHeaders)) {
        foreach ($httpHeaders as $httpHeader) {
            header($httpHeader);
        }
    }

    http_response_code($statusCode);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

// request have content type json
function isRequestContentTypeJson(){
    return (isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] == 'application/json');
}

// dump code
function dd($code){
    echo '<pre>';
    var_dump($code);
    echo '</pre>';
    exit;
}
