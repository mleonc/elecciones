<?php

require __DIR__.'/vendor/autoload.php';

use Indoor\Http\Exceptions\HttpRequestNoRoute;
use Indoor\Http\Exceptions\HttpRequestDataNotFound;

try {
    $response = Indoor\Http\Response::response($request = Indoor\Http\Request::capture());
} catch (HttpRequestNoRoute $e) {
    http_response_code($e->getCode());
} catch (HttpRequestDataNotFound $e) {
    http_response_code($e->getCode());
}
