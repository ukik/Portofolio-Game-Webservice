<?php

namespace App\Http\Controllers\Mutation\Resume;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Model\Mutation\Record\GetGame;
use App\Model\Mutation\Record\GetPurchase;
use App\Model\Mutation\Record\GetWithdraw;

use App\Model\Mutation\Record\GetVehicle;
use App\Model\Mutation\Record\GetTools;

class ResumeController extends Controller
{

    public function index(Request $request, $query = "")
    {              
        # last month
        $startMonthly = $this->startMonth(1);
        $endMonthly = $this->endMonth(1);

        # last week 1, this week 0
        $startWeekly = $this->startWeek(0);
        $endWeekly = $this->endWeek(0);

        $startDaily = $this->startToday();
        $endDaily = $this->endToday();

        switch($query){
            case "game":
            case "mission":
                $payload = [
                    'daily'     => GetGame::with('get_user_profile')->query($startDaily, $endDaily)->paginate(7),
                    'weekly'    => GetGame::with('get_user_profile')->query($startWeekly, $endWeekly)->paginate(7),
                    'monthly'   => GetGame::with('get_user_profile')->query($startMonthly, $endMonthly)->paginate(7),
                    'last'      => GetGame::with('get_user_profile')->where('status', '=', 'enable')->where('created_at', '>', $this->startToday())->take(7)->orderBy("id", 'desc')->paginate(25),
                ];    
                break;
            case "purchase":
                $payload = [
                    'daily'     => GetPurchase::with('get_user_profile')->query($startDaily, $endDaily)->paginate(7),
                    'weekly'    => GetPurchase::with('get_user_profile')->query($startWeekly, $endWeekly)->paginate(7),
                    'monthly'   => GetPurchase::with('get_user_profile')->query($startMonthly, $endMonthly)->paginate(7),
                    'last'      => GetPurchase::with('get_user_profile')->where('status', '=', 'enable')->where('created_at', '>', $this->startToday())->take(7)->orderBy("id", 'desc')->paginate(25),
                ];
                break;
            case "upgrade":
                function Tools ($start, $end)
                {
                    return GetTools::with('get_user_profile')->queryTools($start, $end)->paginate(7);
                }
                function Vehicle ($start, $end)
                {
                    return GetVehicle::with('get_user_profile')->queryVehicle($start, $end)->paginate(7);
                }

                $payload = [
                    'daily'     => $data = Vehicle($startDaily, $endDaily)->union(Tools ($startDaily, $endDaily)),
                    'weekly'    => $data = Vehicle($startWeekly, $endWeekly)->union(Tools ($startWeekly, $endWeekly)),
                    'monthly'   => $data = Vehicle($startMonthly, $endMonthly)->union(Tools ($startMonthly, $endMonthly)),
                    'last'      => GetTools::with('get_user_profile')->where('status', '=', 'enable')->where('created_at', '>', $this->startToday())->take(7)->orderBy("id", 'desc')->paginate(25),
                ];                 
                break;
            case "withdraw":
                $payload = [
                    'daily'     => GetWithdraw::with('get_user_profile')->query($startDaily, $endDaily)->paginate(7),
                    'weekly'    => GetWithdraw::with('get_user_profile')->query($startWeekly, $endWeekly)->paginate(7),
                    'monthly'   => GetWithdraw::with('get_user_profile')->query($startMonthly, $endMonthly)->paginate(7),
                    'last'      => GetWithdraw::with('get_user_profile')->where('status', '=', 'enable')->where('created_at', '>', $this->startToday())->take(7)->orderBy("id", 'desc')->paginate(25),
                ];                    
                break;
        }
        
        return response()
        ->json([
            'security' => getter('security'), 
            'model' => $payload
        ]);
    }
}
