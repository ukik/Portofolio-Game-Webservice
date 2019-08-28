<?php

use Closure;

class Agent
{

    public function handle($request, Closure $next)
    {

        $parameter  = [];
        $keys       = [];
        $values     = [];

        foreach ($_REQUEST as $key => $value) {
            $parameter += [$key => $value];
            array_push($keys, $key);
            array_push($values, $value);
        }

        setter('request', $parameter);
        setter('request_keys', $keys);
        setter('request_values', $values);

        return $next($request);

        # to protocol decrypt

    }

    public function terminate($request, $response)
    {
        return "protocol clear";
    }

}
