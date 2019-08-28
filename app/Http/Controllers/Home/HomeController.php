<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\User\GetWallet; # Temporari
use App\Model\User\GetSummary; # Abadi

class HomeController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function verifikasi() {
        return view('verification');
    }

    public function leaderboard($path){

        $path = request()->segment(count(request()->segments()));

        switch ($path) {
            case 'all':
                return view('leaderboard.'.$path, 
                    [ 'title' => 'Top Score', 'path' => $path ]
                );
                break;
            case 'tournament':
                $tournament = \App\Model\Library\GetTournament::first();
                return view('leaderboard.'.$path, 
                    [ 'title' => 'Turnamen Mingguan Score', 'path' => $path, 'tournament' => $tournament ]);
                break;
            default:
                return responses('error');
                break;
        }
    }

    public function leaderboardAPI()
    {
        $bronze = 7;
        $silver = 11;
        $gold = 14;
        $platinum = 17;
        $diamond = 21;

        $GetWallet = GetWallet::class;

        $path = isset($_GET['path']) &&  $_GET['path'] == 'tournament' ? 'score_tournament' :  'score_in';

        $select = ['code_user','score_in','score_tournament', 'tools_vehicle'];

        $topScore = GetWallet::with('get_user_profile')
            ->select($select)
            ->where($path, '>', 0)
            ->limit(10)
            ->orderBy($path,'desc')
            ->get();

        $dataBronze = $GetWallet::with('get_user_profile')
            ->where('tools_vehicle', '<', $silver)
            ->select($select)
            ->where($path, '>', 0)
            ->limit(10)
            ->orderBy($path,'desc')
            ->get();

        $dataSilver = $GetWallet::with('get_user_profile')
            ->where('tools_vehicle', '>=', $silver)
            ->where('tools_vehicle', '<', $gold)
            ->select($select)
            ->where($path, '>', 0)
            ->limit(10)
            ->orderBy($path,'desc')            
            ->get();

        $dataGold = $GetWallet::with('get_user_profile')
            ->where('tools_vehicle', '>=', $gold)
            ->where('tools_vehicle', '<', $platinum)
            ->select($select)
            ->where($path, '>', 0)
            ->limit(10)
            ->orderBy($path,'desc')            
            ->get();

        $dataPlatinum = $GetWallet::with('get_user_profile')
            ->where('tools_vehicle', '>=', $platinum)
            ->where('tools_vehicle', '<', $diamond)
            ->select($select)
            ->where($path, '>', 0)
            ->limit(10)
            ->orderBy($path,'desc')
            ->get();

        $dataDiamond = $GetWallet::with('get_user_profile')
            ->where('tools_vehicle', '>=', $diamond)
            ->select($select)
            ->where($path, '>', 0)
            ->limit(10)
            ->orderBy($path,'desc')            
            ->get();

        $leaderboard = [
            'topscore'      => $topScore,
            'bronze'        => $dataBronze, 
            'silver'        => $dataSilver, 
            'gold'          => $dataGold, 
            'platinum'      => $dataPlatinum, 
            'diamond'       => $dataDiamond,
        ];

        $tournament = \App\Model\Library\GetTournament::first();

        if(date("Y-m-d") > $tournament->day_end) {
            $countdown = 0;
        } else if(date("Y-m-d") <= $tournament->day_end) {
            $countdown = $tournament->day_end;
        }

        return responses(compact('leaderboard', 'countdown'));
    }

    public function upgrade() {
        return view('upgrade');
    }

    public function belanja() {
        return view('belanja');
    }
    
    public function penarikan() {
        return view('penarikan');
    }    
}
