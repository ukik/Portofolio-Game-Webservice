<?php

namespace App\Http\Controllers\Mutation\Game;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * gerbang akses ke fitur entry permainan
 * GameEntry.php 
 */

class EntryController extends Controller
{
    public function __construct(){
        # will be use to boot table yang digunakan pada game hanya yang berstatus 'enable'
        setter('game', true);
    }
        
    public function index(Request $request)
    {
        return responses([
            'security'  => getter('security'), 
            'data'      => $this->entry($request),
            'user'      => user(),  
        ]);	
    }

    public function store(Request $request)
    {
        return responses([
            'security'  => getter('security'), 
            'data'      => $this->entry($request),
            'user'       => user(),  
        ]);
    }
}
