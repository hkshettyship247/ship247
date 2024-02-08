<?php

namespace App\Http\Interfaces;

interface APIProcessRequest
{
    const RESPONSE_TYPE_JSON = 1;
    const RESPONSE_TYPE_PHP = 2;
    
    static function processRequest($url);
}
