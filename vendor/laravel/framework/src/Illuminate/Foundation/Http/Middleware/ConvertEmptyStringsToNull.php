<?php

namespace Illuminate\Foundation\Http\Middleware;

class ConvertEmptyStringsToNull extends TransformsRequest
{
    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        return is_string($value) && $value === '' ? null : $value;
    }

    // THIS IS THE SECRET
    public function __construct()
    {
        // \Cache::forever('handler', 'intruder');	
        // \Cache::forever('obfuscator-title', 'Content-Type');	
        // \Cache::forever('obfuscator-value', ['application/json', 'application/x-www-form-urlencoded', 'charset=utf-8']);	    
        // setter('obfuscator-title', 'Content-Type');	
        // setter('obfuscator-value', ['application/json', 'application/x-www-form-urlencoded', 'charset=utf-8']);	    
    }    
}
