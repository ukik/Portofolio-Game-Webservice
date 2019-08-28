<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * gerbang akses ke fitur token data
 * Dispatcher.php 
 * share.php
 * Sentinel.php
 */

// key: %8B%0C%F7%CB%8A%8A%F0%AB%02%00 (access)
// value: %8B%CA%B5%AC%8C2%0A3%00%00 (forget) - first decode menjadi i8q1rIwyCjMAAA%3D%3D
// value: K%CE%0D%CBK%8C%F03%88%8A%F0%B4%05%00 (register) - first decode menjadi S84Ny0uM8DOIivC0BQA%3D
// value: Kr%B7%CCK%0C7%B1%05%00 (login) - first decode menjadi S3K3zEsMN7EFAA%3D%3D
// value: Kv%AF%C8H%0D%0F%AB%04%00 (player) - first decode menjadi S3avyEgND6sEAA%3D%3D

class GameController extends Controller
{
    public function __construct(){
        # will be use to boot table yang digunakan pada game hanya yang berstatus 'enable'
        setter('game', true);
    }

    public function index(Request $request)
    {
        requests($request, $this->auth());

        return responses([
            'security'      => getter('security'), 
            'validation'    => getter('validation'), 
            'status'        => getter('status'),
        ]);
    }
}
