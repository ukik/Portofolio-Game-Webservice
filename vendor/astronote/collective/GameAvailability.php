<?php

use App\Model\Channel\ChannelHelperLibraryAchievement as LibraryAchievement;
use App\Model\Channel\ChannelHelperLibraryTools as HelperLibraryTools;
use App\Model\Channel\ChannelHelperLibraryVehicle as HelperLibraryVehicle;
use App\Model\Channel\ChannelHelperMutationToolsVehicle as GetToolsVehicle;

use App\Model\Library\GetHelp as GetHelp;
use App\Model\Library\GetIntro as LibraryIntro;
use App\Model\Library\GetMission as LibraryMission;
use App\Model\Library\GetPurchase as GetPurchase;
use App\Model\Library\GetWithdraw as LibraryWithdraw;

use App\Model\Mutation\Record\GetAchievement;
use App\Model\Mutation\Record\GetMission;
use App\Model\Mutation\Record\GetTools;
use App\Model\Mutation\Record\GetVehicle;
use App\Model\Mutation\Record\GetWithdraw;
use App\Model\Mutation\Reference\GetIntro;

use App\Model\User\GetSummary;
use App\Model\User\GetUser;
use App\Model\User\GetWallet;

use App\Model\User\PostUser;

use DB;
use Carbon;

trait GameAvailability
{

    private $value;

    # once transaction
    # if your requirement is insufficent then data would be rendered as false
    # if your requirement is sufficent then data would be rendered from library as true
    # suitable to list achievement on board
    protected function AchievementAvailability()
    {
        $code_user = getter('user')->code_user;

        $mutation = GetAchievement::class;

        $label = 'D';
        setter('table_helper', 'channel_helper_library_achievement_d');
        if($mutation::label($label) >= 8){
            $label = 'C';
            setter('table_helper', 'channel_helper_library_achievement_c');
            if($mutation::label($label) >= 8){
                $label = 'B';
                setter('table_helper', 'channel_helper_library_achievement_b');
                if($mutation::label($label) >= 8){
                    $label = 'A';
                    setter('table_helper', 'channel_helper_library_achievement_a');
                }
            }
        };

        $wallet = GetSummary::where('code_user', '=', $code_user)->first();

        $library = LibraryAchievement::class;


        // data library yang muncul disini sudah bisa diclaim oleh user bersangkutan
        $query_library = $library::
            select(
                DB::raw('
                    code_achievement,
                    title,
                    description,
                    term,
                    label,
                    cash,
                    coin,
                    score,
                    target,
                    status,
                    "" as available
                ')
            )
            ->whereRaw('(target <= ? and term = "cash_collected")', $wallet->cash_in)
            ->orWhereRaw('(target <= ? and term = "coin_collected")', $wallet->coin_in)
            ->orWhereRaw('(target <= ? and term = "score_collected")', $wallet->score_in)
            ->orWhereRaw('(target <= ? and term = "mission_completed")', ($wallet->premium + $wallet->normal))
            ->orWhereRaw('(target <= ? and term = "mission_failed")', $wallet->failed)
            ->orWhereRaw('(target <= ? and term = "premium_played")', $wallet->premium)
            ->orWhereRaw('(target <= ? and term = "normal_played")', $wallet->normal)
            ->orWhereRaw('(target <= ? and term = "bonus_collected")', $wallet->bonus_in);

        // akan dilakukan check untuk memastikan jika user sudah pernah melakukan claim
        // data yang muncul dari filter ini dianggap sudah melakukan claim
        // untuk menampilkan list data yang sudah claim
        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->whereIn('code_achievement', $query_library->pluck('code_achievement'))
            ->pluck('code_achievement', 'label');

        // belum diambil claim
        // data yang muncul disini dianggap belum melakukan claim (unclaimed)
        // tapi sudah bisa claim
        $enable_library = $query_library
            ->select(
                DB::raw('
                    code_achievement,
                    title,
                    description,
                    term,
                    label,
                    cash,
                    coin,
                    score,
                    target,
                    status
                ')
            )
            // jika get_mutation_achievement == null maka belum diambil
            // jika get_mutation_achievement != null maka sudah diambil
            ->with(['get_mutation_achievement' => function ($query) use ($code_user) {
                return $query->where('code_user', $code_user);
            }])
            ->whereNotIn('code_achievement', $query_mutation);

        setter('additional', $library::paginate(50));

        return $enable_library->paginate(50);

    }

    # once transaction
    protected function IntroAvailability()
    {
        $code_user  = getter('user')->code_user;

        $library    = LibraryIntro::class;
        $mutation   = GetIntro::class;

        $query_library = $library::
            pluck('code_intro');

        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->whereIn('code_intro', $query_library)
            ->pluck('code_intro');

        $enable_library = $library::
            whereNotIn('code_intro', $query_mutation)
            ->paginate(50);

        return $enable_library;
    }

    protected function ProfileAvailability()
    {
        $code_user  = getter('user')->code_user;

        $library    = GetToolsVehicle::class;
        $user       = GetUser::class;

        // untuk menampilkan vehicle/tools yang dimiliki
        $library_query = $library::
            select(
                DB::raw(
                    '
                    code_user,
                    code_tools_vehicle,
                    code_this,
                    package,
                    title,
                    level,
                    name,
                    CASE WHEN sum(level) = (1) THEN 1
                            WHEN sum(level) = (1+2) THEN 2
                            WHEN sum(level) = (1+2+3) THEN 3
                            ELSE max(level)
                    END AS level
                    '
                )
            )
            ->with('get_vehicle_meter')
            ->where('code_user', $code_user)
            ->groupBy(['code_user', 'package']);

        $user_query = $user::where('code_user', $code_user)
            ->select(['code_user', 'name', 'plain', 'address', 'phone', 'email'])
            ->first();

        setter('additional', $user_query);

        return $library_query->paginate(50);
    }

    # once transaction can be overrided if neccessary
    protected function ToolsAvailability()
    {
        $code_user  = getter('user')->code_user;

        $library    = HelperLibraryTools::class;
        $mutation   = GetTools::class;

        $wallet = GetWallet::
            where('code_user', '=', $code_user)
            ->first();

        $max_level = $mutation::
            select(
                DB::raw(
                    '
                    code_user,
                    level,
                    CASE WHEN sum(level) = (1) THEN 1
                            WHEN sum(level) = (1+2) THEN 2
                            WHEN sum(level) = (1+2+3) THEN 3
                            ELSE max(level)
                    END AS level
                    '
                )
            )
            ->where('code_user', $code_user)
            ->groupBy(['code_user', 'package'])
            ->pluck('level');

        // melakukan checking apakah user sudah melakukan pembelian tools di table mutasi
        $query_library = $library::
            // menentukan total harga yang dibayar
            select(DB::raw('*'))
            ->join(
                DB::raw('
                    (select
                        code_user,
                        code_tools
                    from
                        mutation_record_tools
                    where
                        code_user = "' . $code_user . '"
                    group by id) as mutation_record_tools
                '), 
                function ($join) {
                    $join->on(
                        'mutation_record_tools.code_tools', '=', 'channel_helper_library_tools.code_tools'
                    );
                }
            )
            // memastikan pembatasan list tools yang dimunculkan sesuai dengan pemiliknya di mutation_record_tools
            ->whereRaw('
                mutation_record_tools.code_tools in (select code_tools from mutation_record_tools where code_user = ? group by id)
            ', $code_user)
            ->groupBy(['id']);

        // memastikan jika data tools di library sudah dipindahkan ke mutasi
        // jika kosong berarti tidak ada lagi yang bisa dibeli/dimutasi
        // data yang muncul disini adalah yang bisa dibeli karena syaratnya cukup tapi belum dimutasi
        $excluded_library = $library::
            select(
                DB::raw('
                    *,
                    "tools" as type
                ')
            )
            ->whereNotIn('code_tools', $query_library->pluck('code_tools'))
            ->groupBy(['package'])
            ->get();

        // Layer 1: pasang dulu di game
        $library_max = $library::
            select(
                DB::raw('
                    *,
                    "tools" as type
                ')
            )
            ->whereIn('level', $max_level)
            ->get();

        // Layer 2: akan mengganti data additional jika terdapat replacer
        $included_library = $library::
            select(
                DB::raw('
                    *,
                    "tools" as type
                ')
            )
            ->whereIn('code_tools', $query_library->pluck('code_tools'))
            ->get();

        setter('additional', $wallet);


        // Layer 3: akan mengganti data additional jika terdapat replacer
        return [
            'layer1' => $library_max,
            'layer2' => $included_library,
            'layer3' => $excluded_library,
        ];
    }

    # once transaction can be overrided if neccessary
    protected function VehicleAvailability()
    {
        $code_user = getter('user')->code_user;

        $library = HelperLibraryVehicle::class; //LibraryVehicle::class;

        $mutation = GetVehicle::class;

        $wallet = GetWallet::
            where('code_user', '=', $code_user)
            ->first();

        $max_level = $mutation::
            select(
                DB::raw(
                    '
                    code_user,
                    level,
                    CASE WHEN sum(level) = (1) THEN 1
                            WHEN sum(level) = (1+2) THEN 2
                            WHEN sum(level) = (1+2+3) THEN 3
                            ELSE max(level)
                    END AS level
                    '
                )
            )
            ->where('code_user', $code_user)
            ->groupBy(['code_user', 'package'])
            ->pluck('level');

        // melakukan checking apakah user sudah melakukan pembelian vehicle di table mutasi
        $query_library = $library::
            // menentukan total harga yang dibayar
            select(DB::raw('*'))
            ->join(
            DB::raw('
                    (select
                        code_user,
                        code_vehicle
                    from
                        mutation_record_vehicle
                    where
                        code_user = "' . $code_user . '"
                    group by id) as mutation_record_vehicle
                '), 
                function ($join) {
                    $join->on(
                        'mutation_record_vehicle.code_vehicle', '=', 'channel_helper_library_vehicle.code_vehicle'
                    );
                }
            )
            ->whereRaw('
                mutation_record_vehicle.code_vehicle in (select code_vehicle from mutation_record_vehicle where code_user = ? group by id)
            ', $code_user)
            ->groupBy(['id']);

        // memastikan jika data vehicle di library sudah dipindahkan ke mutasi
        // jika kosong berarti tidak ada lagi yang bisa dibeli/dimutasi
        // data yang muncul disini adalah yang bisa dibeli karena syaratnya cukup tapi belum dimutasi
        $enable_library = $library::
            select(
                DB::raw('
                    *,
                    "vehicle" as type
                ')
            )
            ->whereNotIn('code_vehicle', $query_library->pluck('code_vehicle'))
            ->with('get_vehicle_meter')
            ->groupBy(['package'])
            ->get();

        // Layer 1: pasang dulu di game
        $library_max = $library::
            select(
                DB::raw('
                    *,
                    "vehicle" as type
                ')
            )
            ->with('get_vehicle_meter')
            ->whereIn('level', $max_level)
            ->get();

        // Layer 2: akan mengganti data additional jika terdapat replacer
        $disable_library = $library::
            select(
                DB::raw('
                    *,
                    "vehicle" as type
                ')
            )
            ->whereIn('code_vehicle', $query_library->pluck('code_vehicle'))
            ->with('get_vehicle_meter')
            ->get();

        setter('additional', $wallet);

        // Layer 3: akan mengganti data additional jika terdapat replacer
        return [
            'layer1' => $library_max,
            'layer2' => $disable_library,
            'layer3' => $enable_library,
        ];
    }

    protected function WithdrawAvailability()
    {
        $code_user = getter('user')->code_user;

        $library = LibraryWithdraw::class;

        $mutation = GetWithdraw::class;

        $wallet = GetWallet::
            where('code_user', '=', $code_user)
            ->first();

        // check berapa user ini dapat mengakses withdraw
        // sesuai dengan nominal coin n cash yang dimiliki
        $query_library = $library::
            where('status', 'enable')
            ->groupBy(['id'])
            ->havingRaw('SUM(cash + ((cash*fee)/100)) <= ' . $wallet->cash_in . '')
            ->havingRaw('SUM(coin + ((coin*fee)/100)) <= ' . $wallet->coin_in . '');

        // dibatasi 1 hari sekali withdraw
        // mengecek withdraw sudah pernah dilakukan belum hari ini
        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->where('limit', '=', date('Y-m-d'))
            ->pluck('code_withdraw');

        $info = 'open';
        if (count($query_mutation)) {
            $info = 'close';
        }

        $enable_library = $query_library
            ->paginate(50);

        $disable_library = $library::
            whereNotIn('code_withdraw', $query_library->pluck('code_withdraw'))
            ->paginate(50);

        if ($info == 'open') {
            $info_text = "Kamu hanya bisa melakukan 'Withdraw' maksimal 1 kali sehari";
        } else {
            $info_text = "Terimakasih hari ini Kamu sudah melakukan 'Withdraw', tunggu maksimal 1x24 jam untuk dicairkan ke PB-Pay";
        }

        return [
            'disable'   => $disable_library,
            'enable'    => $enable_library,
            'info'      => $info,
            'info_text' => $info_text,
        ];
    }

    protected function MissionAvailability()
    {
        $code_user  = getter('user')->code_user;
        $premium    = isset($_GET['premium']) ? true : false;
        $mode       = isset($_GET['mode']) ? true : false;

        if (!$mode) {
            return [
                "info" => "empty",
            ];
        }

        $driver     = decode_param($_GET['mode']) == 'driver' ? true : false;
        $service    = decode_param($_GET['mode']) == 'service' ? true : false;
        $mode       = decode_param($_GET['mode']);

        setter('client', 'MissionAvailability');

        $current_time = Carbon\Carbon::
            now(new \DateTimeZone('Asia/Makassar'))
            ->addHour(0)->format('H:m:s');

        # akan melakukan checking akses terakhir
        $user   = PostUser::whereCodeUser(getter('user')->code_user);
        $force  = decode_param($_GET['force']);

        $date = '_'.date('d-m-Y');

        if($mode == 'driver'){
            # NULL boleh lewat
            if ($current_time < '06:00:00' && $current_time > '00:00:00') {
                $visit = 'driver_malam_pagi'.$date;
                $wait = round(Calculation_Now_Second($current_time, '06:00:00'));
                if ($mode == 'driver' && $premium && $force == "no") {
                    if ($user->value('visit_driver') == $visit) {
                        //request proccesses cancelled
                        return [
                            "info"          => "wait",
                            "reset"         => $wait,
                            'premium'       => $premium,
                            // 'slot_driver'   => $user->value('slot_driver'),
                            // 'slot_service'  => $user->value('slot_service'),               

                            'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                            'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                            'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                            'slot_driver_pickup'        => $user->value('slot_driver_pickup'),                              
                            'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                            'slot_service_fashion'      => $user->value('slot_service_fashion'),
                            'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
                
                        ];
                    }
                }
            } else if ($current_time < '12:00:00' && $current_time > '06:00:00') {
                $visit = 'driver_pagi_siang'.$date;
                $wait = round(Calculation_Now_Second($current_time, '12:00:00'));
                if ($mode == 'driver' && $premium && $force == "no") {
                    if ($user->value('visit_driver') == $visit) {
                        //request proccesses cancelled
                        return [
                            "info"          => "wait",
                            "reset"         => $wait,
                            'premium'       => $premium,
                            // 'slot_driver'   => $user->value('slot_driver'),
                            // 'slot_service'  => $user->value('slot_service'),       
                            
                            'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                            'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                            'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                            'slot_driver_pickup'        => $user->value('slot_driver_pickup'),                              

                            'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                            'slot_service_fashion'      => $user->value('slot_service_fashion'),
                            'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
                
                        ];
                    }
                }
            } else if ($current_time < '18:00:00' && $current_time > '12:00:00') {
                $visit = 'driver_siang_petang'.$date;
                $wait = round(Calculation_Now_Second($current_time, '18:00:00'));
                if ($mode == 'driver' && $premium && $force == "no") {
                    if ($user->value('visit_driver') == $visit) {
                        //request proccesses cancelled
                        return [
                            "info"          => "wait",
                            "reset"         => $wait,
                            'premium'       => $premium,

                            // 'slot_driver'   => $user->value('slot_driver'),
                            // 'slot_service'  => $user->value('slot_service'),        

                            'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                            'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                            'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                            'slot_driver_pickup'        => $user->value('slot_driver_pickup'),                              
                            'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                            'slot_service_fashion'      => $user->value('slot_service_fashion'),
                            'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
                        ];
                    }
                }
            } else if ($current_time < '23:59:59' && $current_time > '18:00:00') {
                $visit = 'driver_petang_malam'.$date;
                $wait = round(Calculation_Now_Second($current_time, '23:59:59'));
                if ($mode == 'driver' && $premium && $force == "no") {
                    if ($user->value('visit_driver') == $visit) {
                        //request proccesses cancelled
                        return [
                            "info"          => "wait",
                            "reset"         => $wait,
                            'premium'       => $premium,

                            // 'slot_driver'   => $user->value('slot_driver'),
                            // 'slot_service'  => $user->value('slot_service'),    

                            'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                            'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                            'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                            'slot_driver_pickup'        => $user->value('slot_driver_pickup'),                              
                            'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                            'slot_service_fashion'      => $user->value('slot_service_fashion'),
                            'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
                
                        ];
                    }
                }
            }
        }

        if ($mode == 'service') {
            # NULL boleh lewat
            if ($current_time < '06:00:00' && $current_time > '00:00:00') {
                $visit = 'service_malam_pagi'.$date;
                $wait = round(Calculation_Now_Second($current_time, '06:00:00'));
                if ($mode == 'service' && $premium && $force == "no") {
                    if ($user->value('visit_service') == $visit) {
                        //request proccesses cancelled
                        return [
                            "info"          => "wait",
                            "reset"         => $wait,
                            'premium'       => $premium,

                            // 'slot_driver'   => $user->value('slot_driver'),
                            // 'slot_service'  => $user->value('slot_service'),                        
                            'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                            'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                            'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                            'slot_driver_pickup'        => $user->value('slot_driver_pickup'),  

                            'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                            'slot_service_fashion'      => $user->value('slot_service_fashion'),
                            'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
                
                        ];
                    }
                }
            } else if ($current_time < '12:00:00' && $current_time > '06:00:00') {
                $visit = 'service_pagi_siang'.$date;
                $wait = round(Calculation_Now_Second($current_time, '12:00:00'));
                if ($mode == 'service' && $premium && $force == "no") {                
                    if ($user->value('visit_service') == $visit) {
                        //request proccesses cancelled
                        return [
                            "info"          => "wait",
                            "reset"         => $wait,
                            'premium'       => $premium,

                            // 'slot_driver'   => $user->value('slot_driver'),
                            // 'slot_service'  => $user->value('slot_service'),

                            'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                            'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                            'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                            'slot_driver_pickup'        => $user->value('slot_driver_pickup'),                              
                            'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                            'slot_service_fashion'      => $user->value('slot_service_fashion'),
                            'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
                
                        ];
                    }
                }
            } else if ($current_time < '18:00:00' && $current_time > '12:00:00') {
                $visit = 'service_siang_petang'.$date;
                $wait = round(Calculation_Now_Second($current_time, '18:00:00'));
                if ($mode == 'service' && $premium && $force == "no") {                
                    if ($user->value('visit_service') == $visit) {
                        //request proccesses cancelled
                        return [
                            "info"          => "wait",
                            "reset"         => $wait,
                            'premium'       => $premium,

                            // 'slot_driver'   => $user->value('slot_driver'),
                            // 'slot_service'  => $user->value('slot_service'),              
                                      
                            'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                            'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                            'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                            'slot_driver_pickup'        => $user->value('slot_driver_pickup'),  
                            
                            'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                            'slot_service_fashion'      => $user->value('slot_service_fashion'),
                            'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
                        ];
                    }
                }
            } else if ($current_time < '23:59:59' && $current_time > '18:00:00') {
                $visit = 'service_petang_malam'.$date;
                $wait = round(Calculation_Now_Second($current_time, '23:59:59'));
                if ($mode == 'service' && $premium && $force == "no") {                
                    if ($user->value('visit_service') == $visit) {
                        //request proccesses cancelled
                        return [
                            "info"          => "wait",
                            "reset"         => $wait,
                            'premium'       => $premium,

                            // 'slot_driver'   => $user->value('slot_driver'),
                            // 'slot_service'  => $user->value('slot_service'),        

                            'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                            'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                            'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                            'slot_driver_pickup'        => $user->value('slot_driver_pickup'),   

                            'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                            'slot_service_fashion'      => $user->value('slot_service_fashion'),
                            'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
                        ];
                    }
                }
            }
        }

        if (!$driver && !$service) {
            return [
                "info"          => "error",
                "reset"         => $wait,
                'premium'       => $premium,

                // 'slot_driver'   => $user->value('slot_driver'),
                // 'slot_service'  => $user->value('slot_service'),        

                'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                'slot_driver_pickup'        => $user->value('slot_driver_pickup'),                  

                'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                'slot_service_fashion'      => $user->value('slot_service_fashion'),
                'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
    
            ];
        }

        setter('premium', $premium);

        $limit = DB::
            table('library_limit')
            ->pluck('range', 'label');

        $mutation       = GetMission::class;
        $library        = LibraryMission::class;
        $toolsvehicle   = GetToolsVehicle::class;

        // difficulty digunakan untuk melakukan potongan bedasarkan: hard, medium, easy
        $difficulty = GetWallet::
            select(
                DB::raw(
                    '
                    code_user,
                    cash_in,
                    CASE WHEN cash_in < ' . $limit['min'] . ' THEN "easy"
                        WHEN cash_in BETWEEN ' . $limit['min'] . ' AND ' . $limit['max'] . ' THEN "medium"
                        WHEN cash_in > ' . $limit['min'] . ' THEN "hard"
                    END as difficulty
                    '
                )
            )
            ->where('code_user', '=', $code_user)
            ->value('difficulty');

        $code_tools_vehicle = $toolsvehicle::
            pluck('code_tools_vehicle');

        $tools_vehicle = $toolsvehicle::
            select(
                DB::raw(
                    '
                    *,
                    CASE WHEN sum(level) = (1) THEN 1
                        WHEN sum(level) = (1+2) THEN 2
                        WHEN sum(level) = (1+2+3) THEN 3
                        ELSE max(level)
                    END AS level
                    '
                )
            )
            ->where('code_user', $code_user)
            ->groupBy([
                'code_user',
                'package',
            ]);

        // check vehicle/tools yang sudah dimiliki
        $query_mutation = $mutation::
            select(
                DB::raw("
                    mutation_record_mission.*,
                    channel_helper_mutation_tools_vehicle.code_user,
                    channel_helper_mutation_tools_vehicle.code_tools_vehicle
                ")
            )
            ->join(
                'channel_helper_mutation_tools_vehicle', function ($join) {
                    $join->on('channel_helper_mutation_tools_vehicle.code_user', '=', 'mutation_record_mission.code_user');
                }
            )
            ->premium($premium)
            ->where('mutation_record_mission.date', '=', Carbon\Carbon::now()->format('Y-m-d'))
            ->whereIn('mutation_record_mission.code_tools_vehicle', $code_tools_vehicle)
            ->whereIn('channel_helper_mutation_tools_vehicle.code_tools_vehicle', $code_tools_vehicle)
            ->whereIn('mutation_record_mission.key_package', $tools_vehicle->pluck('package'))
            ->whereIn('mutation_record_mission.key_level', $tools_vehicle->pluck('level'))
            ->groupBy([
                'mutation_record_mission.code_mission'
            ])
            ->orderBy('mutation_record_mission.id', 'asc');

        // list ini akan dipilih oleh player 'premium mission'
        // randomly will select only 1
        // list akan berkurang ketika as motorcycle, motorbox, mobil, pickup, fashion, cleaner, washer, service has been transfered to mutation_record_mission by today unique
        $data_library_mission = $library::
            select(
                DB::raw(
                    '
                    DISTINCT
                        code_mission,
                        title,
                        mode,
                        difficulty,
                        premium,
                        normal,
                        package,
                        cash,
                        coin,
                        score,
                        timer,
                        status
                    '
                )
            )
            ->premium($premium)
            ->where('difficulty', $difficulty)
            ->whereIn('package', $tools_vehicle->pluck('package'))
            ->whereNotIn('code_mission', $query_mutation->pluck('code_mission'))
            ->inRandomOrder();
        
        /*
        $slot = $tools_vehicle->groupBy(['mode'])->totalSlot($mode)[0]->slot;

        if ($premium && $force == 'yes') {
            switch ($mode) {
                case 'driver':

                    $user->update([
                        'visit_driver' => $visit,
                        'slot_driver' => PremiumSlot($difficulty) + $slot,
                    ]);
                    
                    break;
                case 'service':

                    $slot_service = $toolsvehicle
                        ::wherePackage('service')
                        ->where('code_user', $code_user)
                        ->sum('slot');

                    $slot_washer = $toolsvehicle
                        ::wherePackage('washer')
                        ->where('code_user', $code_user)
                        ->sum('slot');

                    $slot_fashion = $toolsvehicle
                        ::wherePackage('fashion')
                        ->where('code_user', $code_user)
                        ->sum('slot');

                    $user->update([
                        'visit_service' => $visit,
                        'slot_service'  => PremiumSlot($difficulty) + $slot, // 

                        'slot_service_fashion'      => PremiumSlot($difficulty) + $slot_fashion,
                        'slot_service_kebersihan'   => PremiumSlot($difficulty) + $slot_service,
                        'slot_service_pencucian'    => PremiumSlot($difficulty) + $slot_washer,
                    ]);

                    break;
            }
        }
        */
        return $too = [
            'difficulty'            => $difficulty,
            'premium'               => $premium,
            'reset'                 => $wait,
            'visit'                 => $visit,

            //'slot_driver'           => $user->value('slot_driver'),
            //'slot_service'          => $user->value('slot_service'),

            'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
            'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
            'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
            'slot_driver_pickup'        => $user->value('slot_driver_pickup'),             

            'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
            'slot_service_fashion'      => $user->value('slot_service_fashion'),
            'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         

            'tools_vehicle'         => $tools_vehicle->paginate(),
            'query_mutation'        => $query_mutation->paginate(count($query_mutation->pluck('id'))),
            'count_library_mission' => count($data_library_mission->orderBy('created_at', 'desc')->get()),
            'data_library_mission'  => $data_library_mission
                ->whereMode($mode)
                ->orderBy('created_at', 'desc')
                ->paginate($premium ? 45 : 25),
        ];
    }

    protected function LeaderboardAvailability()
    {
        $code_user = getter('user')->code_user;
        
        // yang benar ambil dari GetSummary (perbaiki), bukan GetWallet
        return GetSummary::with([ 
            'get_user_profile',
            'get_leaderboard',
        ])
        ->where('code_user', '=', $code_user)
        ->first();
    }

    protected function PurchaseAvailability()
    {
        # code...
        return GetPurchase::paginate(50);
    }

    protected function HelpAvailability()
    {
        # code...
        return GetHelp::paginate(50);
    }

    protected function PremiumSlotAvailability()
    {
        $code_user  = getter('user')->code_user;

        $current_time = Carbon\Carbon::
            now(new \DateTimeZone('Asia/Makassar'))
            ->addHour(0)->format('H:m:s');

        # akan melakukan checking akses terakhir
        $user   = PostUser::whereCodeUser(getter('user')->code_user);

        $date = '_'.date('d-m-Y');

        # NULL boleh lewat
        if ($current_time < '06:00:00' && $current_time > '00:00:00') {
            $visit_service = 'service_malam_pagi'.$date;
            $visit_driver = 'driver_malam_pagi'.$date;
            $wait = round(Calculation_Now_Second($current_time, '06:00:00'));
            if ($user->value('visit_service') == $visit_service && $user->value('visit_driver') == $visit_driver) {
                //request proccesses cancelled
                return [
                    //'slot_driver'   => $user->value('slot_driver'),
                    //'slot_service'  => $user->value('slot_service'),

                    'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                    'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                    'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                    'slot_driver_pickup'        => $user->value('slot_driver_pickup'), 

                    'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                    'slot_service_fashion'      => $user->value('slot_service_fashion'),
                    'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),                                         
                ];
            }


        } else if ($current_time < '12:00:00' && $current_time > '06:00:00') {
            $visit_service = 'service_pagi_siang'.$date;
            $visit_driver = 'driver_pagi_siang'.$date;
            $wait = round(Calculation_Now_Second($current_time, '12:00:00'));
            if ($user->value('visit_service') == $visit_service && $user->value('visit_driver') == $visit_driver) {
                //request proccesses cancelled
                return [
                    //'slot_driver'   => $user->value('slot_driver'),
                    //'slot_service'  => $user->value('slot_service'),

                    'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                    'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                    'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                    'slot_driver_pickup'        => $user->value('slot_driver_pickup'), 

                    'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                    'slot_service_fashion'      => $user->value('slot_service_fashion'),
                    'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),         
                ];
            }            
        } else if ($current_time < '18:00:00' && $current_time > '12:00:00') {
            $visit_service = 'service_siang_petang'.$date;
            $visit_driver = 'driver_siang_petang'.$date;
            $wait = round(Calculation_Now_Second($current_time, '18:00:00'));
            if ($user->value('visit_service') == $visit_service && $user->value('visit_driver') == $visit_driver) {
                //request proccesses cancelled
                return [
                    //'slot_driver'   => $user->value('slot_driver'),
                    //'slot_service'  => $user->value('slot_service'),

                    'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                    'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                    'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                    'slot_driver_pickup'        => $user->value('slot_driver_pickup'), 

                    'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                    'slot_service_fashion'      => $user->value('slot_service_fashion'),
                    'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),         
                ];
            }            
        } else if ($current_time < '23:59:59' && $current_time > '18:00:00') {
            $visit_service = 'service_petang_malam'.$date;
            $visit_driver = 'driver_petang_malam'.$date;
            $wait = round(Calculation_Now_Second($current_time, '23:59:59'));
            if ($user->value('visit_service') == $visit_service && $user->value('visit_driver') == $visit_driver) {
                //request proccesses cancelled
                return [
                    //'slot_driver'   => $user->value('slot_driver'),
                    //'slot_service'  => $user->value('slot_service'),

                    'slot_driver_motorbox'      => $user->value('slot_driver_motorbox'), 
                    'slot_driver_motorcycle'    => $user->value('slot_driver_motorcycle'), 
                    'slot_driver_mobil'         => $user->value('slot_driver_mobil'),  
                    'slot_driver_pickup'        => $user->value('slot_driver_pickup'),                      
                    'slot_service_pencucian'    => $user->value('slot_service_pencucian'),
                    'slot_service_fashion'      => $user->value('slot_service_fashion'),
                    'slot_service_kebersihan'   => $user->value('slot_service_kebersihan'),         
                ];
            }            
        }

        $toolsvehicle   = GetToolsVehicle::class;

        $limit = DB::
            table('library_limit')
            ->pluck('range', 'label');

        // difficulty digunakan untuk melakukan potongan bedasarkan: hard, medium, easy
        $difficulty = GetWallet::
            select(
                DB::raw(
                    '
                    code_user,
                    cash_in,
                    CASE WHEN cash_in < ' . $limit['min'] . ' THEN "easy"
                        WHEN cash_in BETWEEN ' . $limit['min'] . ' AND ' . $limit['max'] . ' THEN "medium"
                        WHEN cash_in > ' . $limit['min'] . ' THEN "hard"
                    END as difficulty
                    '
                )
            )
            ->where('code_user', '=', $code_user)
            ->value('difficulty');

        /*
        $tools_vehicle = $toolsvehicle::
            select(
                DB::raw(
                    '
                    *,
                    CASE WHEN sum(level) = (1) THEN 1
                        WHEN sum(level) = (1+2) THEN 2
                        WHEN sum(level) = (1+2+3) THEN 3
                        ELSE max(level)
                    END AS level
                    '
                )
            )
            ->where('code_user', $code_user)
            ->groupBy([
                'code_user',
                'package',
            ]);        
        */        

        //$slot_driver = $tools_vehicle->groupBy(['mode'])->totalSlot('driver')[0]->slot;
        // $slot_driver = $toolsvehicle
        //     ::where('mode', 'driver')
        //     ->where('code_user', $code_user)
        //     ->sum('slot');

        // $slot_driver <= 0 ? 0 : $slot_driver + PremiumSlot($difficulty);

        $slot_motorcycle = $toolsvehicle
            ::wherePackage('motorcycle')
            ->where('code_user', $code_user)
            ->sum('slot');

        $slot_motorcycle <= 0 ? 0 : $slot_motorcycle + PremiumSlot($difficulty);

        $slot_motorbox = $toolsvehicle
            ::wherePackage('motorbox')
            ->where('code_user', $code_user)
            ->sum('slot');

        $slot_motorbox <= 0 ? 0 : $slot_motorbox + PremiumSlot($difficulty);

        $slot_mobil = $toolsvehicle
            ::wherePackage('mobil')
            ->where('code_user', $code_user)
            ->sum('slot');

        $slot_mobil <= 0 ? 0 : $slot_mobil + PremiumSlot($difficulty);

        $slot_pickup = $toolsvehicle
            ::wherePackage('pickup')
            ->where('code_user', $code_user)
            ->sum('slot');

        $slot_pickup <= 0 ? 0 : $slot_pickup + PremiumSlot($difficulty);
        
        $slot_service = $toolsvehicle
            ::wherePackage('service')
            ->where('code_user', $code_user)
            ->sum('slot');

        $slot_service <= 0 ? 0 : $slot_service + PremiumSlot($difficulty);

        $slot_washer = $toolsvehicle
            ::wherePackage('washer')
            ->where('code_user', $code_user)
            ->sum('slot');

        $slot_washer <= 0 ? 0 : $slot_washer + PremiumSlot($difficulty);

        $slot_fashion = $toolsvehicle
            ::wherePackage('fashion')
            ->where('code_user', $code_user)
            ->sum('slot');

        $slot_fashion <= 0 ? 0 : $slot_fashion + PremiumSlot($difficulty);

        $user->update([
            'visit_driver' => $visit_driver,
            'visit_service' => $visit_service,

            // 'slot_driver' => $slot_driver,
            //'slot_service'  => PremiumSlot($difficulty) + $slot_service,
            'slot_service_fashion'      => $slot_fashion, 
            'slot_service_kebersihan'   => $slot_service,
            'slot_service_pencucian'    => $slot_washer,

            'slot_driver_motorbox'      => $slot_motorbox, 
            'slot_driver_motorcycle'    => $slot_motorcycle,
            'slot_driver_mobil'         => $slot_mobil,
            'slot_driver_pickup'        => $slot_pickup,
        ]);
        
        //$code_user = getter('user')->code_user;
        return GetUser::
            where('code_user', '=', $code_user)
            ->select([
                'slot_driver_motorbox', 
                'slot_driver_motorcycle', 
                'slot_driver_mobil', 
                'slot_driver_pickup', 

                'slot_service_fashion', 
                'slot_service_kebersihan', 
                'slot_service_pencucian',
            ])
            ->first();
    }

    public function Availability()
    {
        //K4%0A3%05%00 = key
        //%0Bv%0F%2BNv%B4%B5%05%00 = Help
        //%0B%0C%F7%CBO%0C%0F3%8A%0A7%CCI%CA%0B%B4%05%00 = Achievement
        //%0B%0E75H%CE%B5%B0%05%00 = Intro
        //%0Bs%B7%2CK%F2%F0%B5%05%00 = Tools
        //%0B%CB%0D%CBO%0C%F7%2B%8E%0A%B4%B5%05%00 = Vehicle
        //%0B3%CA1Ht%0F%AA%8C%8CH%B6%05%00 = Withdraw
        //%0B%09%CF%A9J6%CA%29KJ%B7%B5%05%00 = Mission
        //%0Bq%0F%CB%88r%0F%AB%8C%CC%B5%CCH%CE%0D%B4%05%00 = Leaderboard
        //%0B%F5%F0%2A%8B%CA%CD%29%8E%0A%B4%B5%05%00 = Profile
        //%0B%F5%08%AB%8C4%CA%C8H6%0A%B5%05%00 = Purchase
        //%0B%F5%F0%CAI%0A%CF1L%0A%F3%2BN2%0E%B4%05%00 = PremiumSlot

        //mode
        //%8B%F2%F0%2AH%C9%0D%AB%04%00 = driver
        //K6%0A%ABL%C9%CD%C9%8A%0A%B4%B5%05%00 = service

        $key = [];

        for ($i = 0; $i < count(getter('request')); $i++) {
            $key += [decode_key(getter('request'), $i) => decode_value(getter('request'), $i)];
        }

        switch ($key['key']) {
            case 'PremiumSlot': 
                return $this->PremiumSlotAvailability();
                break;
            case 'Profile':
                return $this->ProfileAvailability();
                break;
            case 'Purchase': // yang belum, butuh inAppPurchase
                return $this->PurchaseAvailability();
                break;
            case 'Achievement':
                return $this->AchievementAvailability();
                break;
            case 'Intro':
                return $this->IntroAvailability();
                break;
            case 'Tools':
                return $this->ToolsAvailability();
                break;
            case 'Vehicle':
                return $this->VehicleAvailability();
                break;
            case 'Withdraw':
                return $this->WithdrawAvailability();
                break;
            case 'Mission':
                return $this->MissionAvailability();
                break;
            case 'Leaderboard':
                return $this->LeaderboardAvailability();
                break;
            case 'Help':
                return $this->HelpAvailability();
                break;
        }
    }
}
