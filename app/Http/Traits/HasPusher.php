<?php

namespace App\Http\Traits;

trait HasPusher
{
    function callController($class, $method, $requestClass, $data)
    {
        $requestSending = new $requestClass;
        $requestSending->replace($data);

        $response = app($class)->{$method}($requestClass::createFromBase($requestSending));
        return $response;
    }
}
