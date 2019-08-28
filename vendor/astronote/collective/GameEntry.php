<?php

use App\Model\Channel\ChannelHelperLibraryAchievement as LibraryAchievement;
use App\Model\Channel\ChannelHelperLibraryTools as HelperLibraryTools;
use App\Model\Channel\ChannelHelperLibraryVehicle as HelperLibraryVehicle;
use App\Model\Channel\ChannelHelperMutationToolsVehicle as PostToolsVehicle;

use App\Model\Library\GetWithdraw as LibraryWithdraw;
use App\Model\Library\PostMission as LibraryMission;

use App\Model\Library\GetTournament;
use App\Model\Library\PostTournament;

use App\Model\Mutation\Record\PostAchievement;
use App\Model\Mutation\Record\PostMission;
use App\Model\Mutation\Record\PostTools;
use App\Model\Mutation\Record\PostVehicle;
use App\Model\Mutation\Record\PostWithdraw;
use App\Model\Mutation\Record\PostGame;

use App\Model\User\PostSummary;
use App\Model\User\PostUser;
use App\Model\User\PostWallet;
use App\Model\User\GetUser;

use DB;
use Faker;
use Illuminate\Http\Request;
use Validator;

trait GameEntry
{
    protected function AchievementEntry($request)
    {
        $faker              = Faker\Factory::create();

        $code_user          = getter('user')->code_user;
        $code_achievement   = $request->code_achievement;

        $mutation           = PostAchievement::class;

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

        $summary = PostSummary::where('code_user', '=', $code_user)->first();

        $library = LibraryAchievement::class;

        // check ulang, benarkah user ini boleh claim?
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
            ->whereRaw('(target <= ? and term = "cash_collected")', $summary->cash_in)
            ->orWhereRaw('(target <= ? and term = "coin_collected")', $summary->coin_in)
            ->orWhereRaw('(target <= ? and term = "score_collected")', $summary->score_in)
            ->orWhereRaw('(target <= ? and term = "mission_completed")', $summary->mission_completed)
            ->orWhereRaw('(target <= ? and term = "mission_failed")', $summary->failed)
            ->orWhereRaw('(target <= ? and term = "premium_played")', $summary->premium)
            ->orWhereRaw('(target <= ? and term = "normal_played")', $summary->normal)
            ->orWhereRaw('(target <= ? and term = "bonus_collected")', $summary->bonus_in);

        // jika hasilnya kosong maka boleh diisi
        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->whereIn('code_achievement', $query_library->pluck('code_achievement'))
            ->where('code_achievement', $code_achievement)
            ->pluck('code_achievement', 'label');

        if (count($query_mutation) > 0) {
            return [
                "info"              => "existed",
                "term"              => null,
                "code_achievement"  => null,
            ];
        }

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
            ->whereNotIn('code_achievement', $query_mutation)
            ->get();

        foreach ($enable_library as $key => $value) {
            if ($value->code_achievement == $code_achievement) {
                $mutation_query = $mutation::create(
                    [
                        'code_user'         => $code_user,
                        'code_achievement'  => $value->code_achievement,
                        'title'             => $value->title,
                        'description'       => $value->description,
                        'term'              => $value->term,
                        'label'             => $value->label,
                        'cash'              => $value->cash,
                        'coin'              => $value->coin,
                        'score'             => $value->score,
                        'target'            => $value->target,
                    ]
                );

                # Update table wallet & table summary
                $payload = [
                    'activity'  => 1,
                    'cash_in'   => $value->cash,
                    'coin_in'   => $value->coin,
                    'score_in'  => $value->score,
                ];
                $this->HelperWalletSummary($payload);

                return [
                    "info"              => "created",
                    "term"              => $value->term,
                    "code_achievement"  => $value->code_achievement,
                    "cash"              => $value->cash,
                    "coin"              => $value->coin,
                ];
            }
        }

        return [
            "info"              => "nothing",
            "term"              => null,
            "code_achievement"  => null,
        ];

    }

    protected function ProfileEntry($request)
    {
        $mutation   = PostUser::class;
        $code_user  = getter('user')->code_user;
        $email      = $mutation::whereCodeUser($code_user)->value('email');

        $v = Validator::make(
            [
                'name'      => $request->name,
                'password'  => $request->password,
                'plain'     => $request->password,
                'address'   => $request->address,
                'email'     => $request->email,
                'scope'     => 'player',
                'phone'     => $request->phone,
            ],
            [
                'name'      => 'required|string|max:255',
                'password'  => 'required|string|min:6',
                'scope'     => 'required|string|in:player',
                'address'   => 'required|string',
                'email'     => $email == $request->email ? 'required|string|email|max:255' : 'required|string|email|max:255|unique:user',
                'phone'     => 'required|numeric|digits_between:8,20|unique:user,phone,NULL,id,email,' . $request->email . ',scope,' . $request->scope,
            ]
        );        

        if ($v->fails()) {
            return [
                "info"      => "failed",
                "profile"   => $v->errors()->all(),
            ];            
        }

        try {
            $mutation_query = $mutation::
                updateOrCreate(
                [
                    'code_user' => $code_user,
                ],
                [
                    'name'      => $request->name,
                    'password'  => bcrypt($request->password),
                    'plain'     => $request->password,
                    'address'   => $request->address,
                    'email'     => $request->email,
                    'scope'     => 'player',
                    'phone'     => $request->phone,                
                ]
            );

            return [
                "info"      => "updated",
                "profile"   => PostUser::where('code_user', $code_user)->get(),
            ];

        } catch (\Exception $e) {
            return [
                "info"      => $e,
                "profile"   => 'error',
            ];
        }

    }

    protected function ToolsEntry($request)
    {
        $faker          = Faker\Factory::create();

        $code_user      = getter('user')->code_user; 
        $code_tools     = $request->code;
        $code_package   = $request->package;

        $data           = 'fashion,cleaner,washer,service';

        $v = Validator::make(
            [
                'user'      => $code_user,
                'tools'     => $code_tools,
                'package'   => $code_package,
            ],
            [
                'user'      => 'required|string',
                'tools'     => 'required|string',
                'package'   => 'required|string|in:' . $data . '|',
            ]
        );

        if ($v->fails()) {
            return [
                "info" => "failed",
            ];
        }

        $library    = HelperLibraryTools::class;
        $mutation   = PostTools::class;
        $wallet     = PostWallet::
            where('code_user', '=', $code_user)
            ->first();

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
        $enabled_library = $library::
            select(
                DB::raw('
                    *,
                    "tools" as type
                ')
            )
            ->whereNotIn('code_tools', $query_library->pluck('code_tools'))
            ->where('code_tools', $code_tools)
            ->where('cash_discount', '<=', $wallet->cash_in)
            ->where('coin_discount', '<=', $wallet->coin_in)
            ->groupBy(['package'])
            ->first();

        if (count($enabled_library) <= 0) {
            return [
                "info" => "failed",
            ];
        }

        $checking = $mutation::
            select(['level', 'package'])
            ->whereCodeUser($code_user)
            ->wherePackage($code_package)
            ->orderBy('level', 'desc')
            ->first();

        // dibuat agar urut dalam membeli
        if ($checking == null) {
                if ($enabled_library->level != 1 || $enabled_library->package != $code_package) {
                    return [
                        "info" => "failed", //"unavailable",
                    ];
                }
        }else{
            switch($checking->level){
                case '1':
                    if ($enabled_library->level != 2 || $enabled_library->package != $code_package) {
                        return [
                            "info" => "failed", //"unavailable",
                        ];
                    }
                    break;
                case '2':
                    if ($enabled_library->level != 3 || $enabled_library->package != $code_package) {
                        return [
                            "info" => "failed", //"unavailable",
                        ];
                    }
                    break;
            }
        }

        // menghitung apakah cash & coin di wall > tools
        // echo "wallet->cash_in ".$wallet->cash_in."\n";
        // echo "wallet->coin_in ".$wallet->coin_in."\n";
        // echo "enabled_library->cash_discount ".$enabled_library->cash_discount."\n";
        // echo "enabled_library->coin_discount ".$enabled_library->coin_discount."\n";

        if($wallet->cash_in < $enabled_library->cash_discount){
            if($wallet->coin_in < $enabled_library->coin_discount){
                return [
                    "info" => "insufficent",
                ];
            }
        }
        
        # Update table wallet & table summary
        PostSummary::
            updateOrCreate(
                [ 'code_user' => $code_user ],
                [
                    'tools_vehicle' => DB::raw('tools_vehicle+1'),
                    'activity'  => 1,
                    'cash_out'  => $enabled_library->cash_discount,
                    'coin_out'  => $enabled_library->coin_discount,
                    'cash_in'   => $enabled_library->cash_discount,
                    'coin_in'   => $enabled_library->coin_discount,
                ]
            );   

        PostWallet::
            updateOrCreate(
                [ 'code_user' => $code_user ],
                [
                    'tools_vehicle' => DB::raw('tools_vehicle+1'),
                    'activity'  => 1,
                    'cash_out'  => -$enabled_library->cash_discount, // menjadi positif
                    'coin_out'  => -$enabled_library->coin_discount, // menjadi positif
                    'cash_in'   => -$enabled_library->cash_discount, // menjadi negatif
                    'coin_in'   => -$enabled_library->coin_discount, // menjadi negatif
                ]
            );    

        $mutation_query = $mutation::create(
            [
                'code_user'     => $code_user,
                'code_this'     => $faker->uuid,
                'code_tools'    => $enabled_library->code_tools,
                'package'       => $enabled_library->package,
                'title'         => $enabled_library->title,
                'level'         => $enabled_library->level,
                'name'          => $enabled_library->name,
                'description'   => $enabled_library->description,
                'cash'          => $enabled_library->cash,
                'coin'          => $enabled_library->coin,
                'discount'      => $enabled_library->discount,
                'status'        => $enabled_library->status,
                'slot'          => $enabled_library->slot,                
            ]
        );

        try {
            
            event(new ToolsEvent($target = $code_user));

        } catch (Exception $e) {

            return [
                "info" => "created",
                "coin" => $enabled_library->cash_discount,
                "cash" => $enabled_library->coin_discount,                       
            ];

        }

        return [
            "info" => "created",
            "coin" => $enabled_library->cash_discount,
            "cash" => $enabled_library->coin_discount,                       
        ];
    }

    protected function VehicleEntry($request)
    {
        $faker          = Faker\Factory::create();

        $code_user      = getter('user')->code_user;
        $code_vehicle   = $request->code;
        $code_package   = $request->package;

        $data = 'motorcycle,motorbox,mobil,pickup';

        $v = Validator::make(
            [
                'user'      => $code_user,
                'vehicle'   => $code_vehicle,
                'package'   => $code_package,
            ],
            [
                'user'      => 'required|string',
                'vehicle'   => 'required|string',
                'package'   => 'required|string|in:' . $data . '|',
            ]
        );

        if ($v->fails()) {
            return [
                "info" => "failed",
            ];
        }

        $library    = HelperLibraryVehicle::class;
        $mutation   = PostVehicle::class;
        $wallet     = PostWallet::
            where('code_user', '=', $code_user)
            ->first();

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
                '), function ($join) {
                    $join
                    ->on(
                        'mutation_record_vehicle.code_vehicle', '=', 'channel_helper_library_vehicle.code_vehicle'
                    );
                }
            )
            // memastikan pembatasan list vehicle yang dimunculkan sesuai dengan pemiliknya di mutation_record_vehicle
            ->whereRaw('
                mutation_record_vehicle.code_vehicle in (select code_vehicle from mutation_record_vehicle where code_user = ? group by id)
            ', $code_user)
            ->groupBy(['id']);
        

        // memastikan jika data vehicle di library sudah dipindahkan ke mutasi
        // jika kosong berarti tidak ada lagi yang bisa dibeli/dimutasi
        // data yang muncul disini adalah yang bisa dibeli karena syaratnya cukup tapi belum dimutasi
        $enabled_library = $library::
            select(
                DB::raw('
                    *,
                    "vehicle" as type
                ')
            )
            ->whereNotIn('code_vehicle', $query_library->pluck('code_vehicle'))
            ->where('code_vehicle', $code_vehicle)
            ->where('cash_discount', '<=', $wallet->cash_in)
            ->where('coin_discount', '<=', $wallet->coin_in)
            ->groupBy(['package'])
            ->first();

        if (count($enabled_library) <= 0) {
            return [
                "info" => "failed",
            ];
        }

        $checking = $mutation::
            select('level')
            ->whereCodeUser($code_user)
            ->wherePackage($code_package)
            ->orderBy('level', 'desc')
            ->first();

        // dibuat agar urut dalam membeli
        if ($checking == null) {
                if ($enabled_library->level != 1 || $enabled_library->package != $code_package) {
                    return [
                        "info" => "unavailable",
                    ];
                }
        }else{
            switch($checking->level){
                case '1':
                    if ($enabled_library->level != 2 || $enabled_library->package != $code_package) {
                        return [
                            "info" => "unavailable",
                        ];
                    }
                    break;
                case '2':
                    if ($enabled_library->level != 3 || $enabled_library->package != $code_package) {
                        return [
                            "info" => "unavailable",
                        ];
                    }
                    break;
            }
        }
        
        // menghitung apakah cash & coin di wall > tools
        // echo "wallet->cash_in ".$wallet->cash_in."\n";
        // echo "wallet->coin_in ".$wallet->coin_in."\n";
        // echo "enabled_library->cash_discount ".$enabled_library->cash_discount."\n";
        // echo "enabled_library->coin_discount ".$enabled_library->coin_discount."\n";

        if($wallet->cash_in < $enabled_library->cash_discount){
            if($wallet->coin_in < $enabled_library->coin_discount){
                return [
                    "info" => "insufficent",
                ];
            }
        }
        
        # Update table wallet & table summary
        PostSummary::
            updateOrCreate(
                [ 'code_user' => $code_user ],
                [
                    'tools_vehicle' => DB::raw('tools_vehicle+1'),
                    'activity'  => 1,
                    'cash_out'  => $enabled_library->cash_discount,
                    'coin_out'  => $enabled_library->coin_discount,
                    'cash_in'   => $enabled_library->cash_discount,
                    'coin_in'   => $enabled_library->coin_discount,
                ]
            );   

        PostWallet::
            updateOrCreate(
                [ 'code_user' => $code_user ],
                [
                    'tools_vehicle' => DB::raw('tools_vehicle+1'),
                    'activity'  => 1,
                    'cash_out'  => -$enabled_library->cash_discount, // menjadi positif
                    'coin_out'  => -$enabled_library->coin_discount, // menjadi positif
                    'cash_in'   => -$enabled_library->cash_discount, // menjadi negatif
                    'coin_in'   => -$enabled_library->coin_discount, // menjadi negatif
                ]
            );          

        $mutation_query = $mutation::create(
            [
                'code_user'     => $code_user,
                'code_vehicle'  => $enabled_library->code_vehicle,
                'code_this'     => $faker->uuid,
                'package'       => $enabled_library->package,
                'title'         => $enabled_library->title,
                'level'         => $enabled_library->level,
                'name'          => $enabled_library->name,
                'description'   => $enabled_library->description,
                'cash'          => $enabled_library->cash,
                'coin'          => $enabled_library->coin,
                'discount'      => $enabled_library->discount,
                'health'        => $enabled_library->health,
                'fuel'          => $enabled_library->fuel,
                'slot'          => $enabled_library->slot,
            ]
        );

        try {

            event(new VehicleEvent($target = $code_user));

        } catch (Exception $e) {

            return [
                "info" => "created",
                "coin" => $enabled_library->cash_discount,
                "cash" => $enabled_library->coin_discount,            
            ];

        }

        return [
            "info" => "created",
            "coin" => $enabled_library->cash_discount,
            "cash" => $enabled_library->coin_discount,            
        ];
    }

    protected function WithdrawEntry($request)
    {
        $faker          = Faker\Factory::create();

        $code_user      = getter('user')->code_user; 
        $code_withdraw  = $request->code_withdraw;

        $library        = LibraryWithdraw::class;
        $mutation       = PostWithdraw::class;
        $wallet         = PostWallet::where('code_user', '=', $code_user);

        $query_library = $library::
            where('cash', '<=', $wallet->first()->cash_in)
            ->where('coin', '<=', $wallet->first()->coin_in)
            ->where('code_withdraw', $code_withdraw)
            ->first();

        // dibatasi 1 hari sekali withdraw
        // mengecek withdraw sudah pernah dilakukan belum hari ini
        $query_mutation = $mutation::
            where('code_user', $code_user)
            ->where('limit', '=', date('Y-m-d'))
            ->pluck('code_withdraw');

        if (count($query_mutation) > 0) {
            return [
                "info" => "existed"
            ];
        }

        $_wallet = $wallet->first();
        $_wallet->cash_in   = $query_library->cash_fee;
        $_wallet->cash_out  = $query_library->cash_fee;
        $_wallet->coin_in   = $query_library->coin_fee;
        $_wallet->coin_out  = $query_library->coin_fee;
        $_wallet->update();

        $mutation_query = $mutation::create(
            [
                'code_user'     => $code_user,
                'code_withdraw' => $query_library->code_withdraw,
                'code_this'     => $faker->uuid,
                'title'         => $query_library->title,
                'label'         => $query_library->label,
                'cash'          => $query_library->cash,
                'coin'          => $query_library->coin,
                'fee'           => $query_library->fee,
                'limit'         => date('Y-m-d'),
                'status'        => 'enable',
            ]
        );

        # Update table wallet & table summary
        $payload = [
            'activity'  => 1,
            'cash_out'  => $enabled_library->cash_discount,
            'coin_out'  => $enabled_library->coin_discount,
            'cash_in'   => $enabled_library->cash_discount,
            'coin_in'   => $enabled_library->coin_discount,
        ];
        $this->HelperWalletSummary($payload);

        try {

            event(new WithdrawEvent($target = $code_user));

        } catch (Exception $e) {

            return [
                "info" => "created",
                "coin" => (($query_library->coin)*$query_library->fee)/100,
                "cash" => (($query_library->cash)*$query_library->fee)/100,
            ];

        }

        return [
            "info" => "created",
            "coin" => (($query_library->coin)*$query_library->fee)/100,
            "cash" => (($query_library->cash)*$query_library->fee)/100,
        ];
    }

    // saat player mengambil misi, misi tersebut langsung di mutasi dengan status done = 'NULL'
    // jika permainan berhasil maka status dirubah done = "complete"
    // jika permainan gagal maka status dirubah done = "failed"
    protected function MissionEntry($request)
    {

        $faker              = Faker\Factory::create();

        $code_user          = getter('user')->code_user; 
        $code_mission       = $request->code;
        $mode               = $request->mode;
        $premium            = $request->premium;
        $current_package    = $request->current_package;

        $request_tools_vehicle = $request->tools_vehicle;

        $limit = DB::
            table('library_limit')
            ->pluck('range', 'label');

        $user = GetUser::class;

        switch ($mode) {
            case 'Kendaraan':
                $mode = 'driver';
                break;
            case 'Jasa':
                $mode = 'service';
                break;
        }

        $slot = $user::whereCodeUser($code_user);

        $_current_package;
        switch ($current_package) {
            case 'motorcycle':
            case 'motorbox':
            case 'mobil':
            case 'pickup':
            case 'fashion':
                $_current_package = $current_package;
                break;
            case 'service':
                $_current_package = 'kebersihan';
                break;
            case 'washer':
                $_current_package = 'pencucian';
                break;
        }  

        if($slot->value('slot_'.$mode.'_'.$_current_package) <= 0 && $premium == "Premium"){
            return [
                "info" => "limit",
            ];
        }

        //if($premium == "Premium") {

            //$slot->value('slot_'.$mode.'_'.$current_package);

            /*
            switch ($mode) {
                case 'Kendaraan':
                    $mode = 'driver';
                    $slot->value('slot_'.$mode.'_'.$current_package);
                    break;
                case 'Jasa':
                    $mode = 'service';
                    $slot->value('slot_'.$mode.'_'.$current_package);
                    break;
            }            
            */

            /*
            if($slot->value('slot_driver_motorbox') <= 0){
                return [
                    "info" => "limit",
                ];
            } else           
            if($slot->value('slot_driver_motorcycle') <= 0){
                return [
                    "info" => "limit",
                ];
            } else           
            if($slot->value('slot_driver_mobil') <= 0){
                return [
                    "info" => "limit",
                ];
            } else           
            if($slot->value('slot_driver_pickup') <= 0){
                return [
                    "info" => "limit",
                ];
            } else           
            if($slot->value('slot_service_fashion') <= 0){
                return [
                    "info" => "limit",
                ];
            } else           
            if($slot->value('slot_service_kebersihan') <= 0){
                return [
                    "info" => "limit",
                ];
            } else           
            if($slot->value('slot_service_pencucian') <= 0){
                return [
                    "info" => "limit",
                ];
            }       
            */     
        //}


        $mutation = PostMission::class;
        $library = LibraryMission::class;
        $toolsvehicle = PostToolsVehicle::class;

        $tools_vehicle = $toolsvehicle::
            select(
                DB::raw(
                    '
                    code_user,
                    code_tools_vehicle,
                    title,
                    code_this,
                    package,
                    level
                    '
                )
            )
            ->where('code_tools_vehicle', $request_tools_vehicle)
            ->groupBy([
                'code_user',
                'package',
            ]);

        $data_library_mission = $library::
            where('code_mission', $code_mission)
            ->groupBy([
                'package',
            ])
            ->orderBy('created_at', 'desc')
            ->first();

        if (count($data_library_mission) <= 0) {
            return [
                "info" => "nothing",
            ];
        }

        try {

            // tambahkan decrement hanya 1 premium
            if($premium == "Premium"){
                //$slot->decrement('slot_'.$mode, 1);
                switch ($current_package) {
                    case 'motorcycle':
                        $slot->decrement('slot_driver_motorcycle', 1);
                        # code...
                        break;
                    case 'motorbox':
                        $slot->decrement('slot_driver_motorbox', 1);
                        # code...
                        break;
                    case 'mobil':
                        $slot->decrement('slot_driver_mobil', 1);
                        # code...
                        break;
                    case 'pickup':
                        $slot->decrement('slot_driver_pickup', 1);
                        # code...
                        break;
                    case 'service':
                        $slot->decrement('slot_service_kebersihan', 1);
                        # code...
                        break;
                    case 'washer':
                        $slot->decrement('slot_service_pencucian', 1);
                        # code...
                        break;
                    case 'fashion': 
                        $slot->decrement('slot_service_fashion', 1);
                        # code...
                        break;
                }                 
            }

            switch ($current_package) {
                case 'motorcycle':
                    $additional_cash    = 60;
                    $additional_coin    = 60;
                    $additional_score   = 60;                        
                    # code...
                    break;
                case 'motorbox':
                    $additional_cash    = 60;
                    $additional_coin    = 60;
                    $additional_score   = 60;                        
                    # code...
                    break;
                case 'mobil':
                    $additional_cash    = 60;
                    $additional_coin    = 60;
                    $additional_score   = 60;                        
                    # code...
                    break;
                case 'pickup':
                    $additional_cash    = 60;
                    $additional_coin    = 60;
                    $additional_score   = 60;                        
                    # code...
                    break;
                case 'service':
                    $additional_cash    = 20;
                    $additional_coin    = 20;
                    $additional_score   = 20;
                    # code...
                    break;
                case 'washer':
                    $additional_cash    = 20;
                    $additional_coin    = 20;
                    $additional_score   = 20;
                    # code...
                    break;
                case 'fashion': 
                    $additional_cash    = 150;
                    $additional_coin    = 150;
                    $additional_score   = 150;
                    # code...
                    break;
            }   

            try {

                event(new MissionEvent($target = $code_user));

            } catch (Exception $e) {

            }

            # Update table wallet & table summary
            $payload = [
                'activity'  => 1,
                'failed'    => 1,
                'premium'   => $data_library_mission->type == 'premium' ? 1 : 0,
                'normal'    => $data_library_mission->type == 'normal' ? 1 : 0,
            ];
            $this->HelperWalletSummary($payload);

            return [
                // 'slot_driver'       => $slot->value('slot_driver'),
                // 'slot_premium'      => $slot->value('slot_service'),

                'slot_driver_motorbox'      => $slot->value('slot_driver_motorbox'), 
                'slot_driver_motorcycle'    => $slot->value('slot_driver_motorcycle'), 
                'slot_driver_mobil'         => $slot->value('slot_driver_mobil'),  
                'slot_driver_pickup'        => $slot->value('slot_driver_pickup'),                  

                'slot_service_pencucian'    => $slot->value('slot_service_pencucian'),
                'slot_service_fashion'      => $slot->value('slot_service_fashion'),
                'slot_service_kebersihan'   => $slot->value('slot_service_kebersihan'),  

                'selected_mission'  => $mutation::create(
                    [
                        'uuid'                  => $faker->uuid,
                        'code_user'             => $code_user,
                        'code_mission'          => $data_library_mission->code_mission,
                        'code_tools_vehicle'    => $request_tools_vehicle,
                        'code_this'             => $request->tools_vehicle, 
                        'date'                  => date('Y-m-d'),
                        'title'                 => $data_library_mission->title,
                        'key_title'             => $tools_vehicle->value('title'),
                        'mode'                  => $data_library_mission->mode,
                        'difficulty'            => $data_library_mission->difficulty,
                        'premium'               => $data_library_mission->type == 'premium' ? 'premium' : null,
                        'normal'                => $data_library_mission->type == 'normal' ? 'normal' : null,
                        'package'               => $data_library_mission->package,
                        'key_package'           => $data_library_mission->package,
                        'timer'                 => $data_library_mission->timer,
                        'cash'                  => $data_library_mission->cash + $additional_cash,
                        'coin'                  => $data_library_mission->coin + $additional_coin,
                        'score'                 => $data_library_mission->score + $additional_score,
                        'done'                  => null, //$code_done, // dibuat otomatis NULL aja
                    ]
                )                         
            ];
        } catch (Exception $e) {
            return [
                "info" => "existed",
            ];
        }

        return [
            "info" => "created",
        ];
    }

    // Executed if Win/Lose/Exit
    public function MissionValidation($request)
    {

        $faker          = Faker\Factory::create();

        $code_uuid      = $request->uuid;
        $code_user      = getter('user')->code_user; 
        $code_mission   = $request->code;

        $post_mission = PostMission::whereUuid($code_uuid)
            ->whereCodeUser($code_user)
            ->whereCodeMission($code_mission);        
    
        $condition = decode_param($_GET['condition']); 

            switch ($post_mission->value('mode')) {
                case 'driver':
                    $game                       = new PostGame;
                    $game->code_user            = $code_user;
                    $game->code_game            = $faker->uuid;
                    $game->code_mission         = $post_mission->value('uuid');
                    $game->code_tools_vehicle   = $post_mission->value('code_tools_vehicle');
                    $game->title                = $post_mission->value('title');
                    $game->premium              = $post_mission->value('premium');
                    $game->normal               = $post_mission->value('normal');
                    $game->mode                 = $post_mission->value('mode'); 
                    $game->total_complain       = $request->game_complain;
                    $game->total_life           = $request->game_life;
                    $game->total_fuel           = $request->game_fuel;
                    $game->total_time           = $request->game_time;
                    $game->total_bonus          = $request->bonus_obtained;
                    $game->cash                 = $request->bonus_cash;
                    $game->coin                 = $request->bonus_coin;
                    $game->score                = [
                                                    'mode'           => $post_mission->value('mode'),
                                                    'game_complain'  => $request->game_complain,
                                                    'game_life'      => $request->game_life,
                                                    'game_fuel'      => $request->game_fuel, 
                                                    'game_time'      => $request->game_time,
                                                    'bonus_obtained' => $request->bonus_obtained,
                                                  ];
                    $game->save();                                            
                    break;
                case 'service':
                    # code...

                    break;
            }

            try {

                event(new GameEvent($target = $code_user));
                
            } catch (Exception $e) {

            }

            # Update table wallet & table summary
            $payload = [
                'activity'  => 1,
                'complete'  => 1,
                'cash_in'   => $post_mission->value('cash') + getter('cash_in'),
                'coin_in'   => $post_mission->value('coin') + getter('coin_in'),
                'score_in'  => $post_mission->value('score') + getter('score_in'),
            ];
            $this->HelperWalletSummary($payload);

            # Update table wallet & table summary Tournament
            $payload_tournament = [
                'score_tournament'  => DB::raw('score_tournament+'.$post_mission->value('score')),
            ];
            $this->HelperWalletSummaryTournament($payload_tournament);

            return [    
                "info"              => "success",
                "security"          => GetUser::whereCodeUser($code_user)->with('wallet')->first(),
                "mission_mutation"  => $post_mission->update([
                    'done' => $condition
                ])
            ];     
            try {

        } catch (Exception $e) {

            return [
                "info" => "error",
            ];
        }                

    }

    public function PurchaseEntry ($request)
    {
        # code...
        event(new PurchaseEvent($target = getter('user')->code_user));

        return 1234;
    }

    private function HelperWalletSummary($payload){

        $code_user = getter('user')->code_user;

        PostSummary::
            updateOrCreate(
                [ 'code_user' => $code_user ],
                $payload
            );   

        PostWallet::
            updateOrCreate(
                [ 'code_user' => $code_user ],
                $payload
            );               
    }    

    private function HelperWalletSummaryTournament($payload)
    {
        # code...
        $carbon_time_zone = \Carbon\Carbon::
            now(new \DateTimeZone('Asia/Makassar'));

        $current_day = $carbon_time_zone->addHour(0)->format('Y-m-d');

        $data_tournament = GetTournament::first();

        $day_begin = $data_tournament->day_begin;
        $day_end = $data_tournament->day_end;
     
        if($current_day >= $day_begin && $current_day <= $day_end){
            $code_user = getter('user')->code_user;

            PostSummary::
                updateOrCreate(
                    [ 'code_user' => $code_user ],
                    $payload
                );   
    
            PostWallet::
                updateOrCreate(
                    [ 'code_user' => $code_user ],
                    $payload
                );         
            
        }
    }

    public function Entry(Request $request)
    {
        //K4%0A3%05%00 = key
        //%0B%0C%F7%CBO%0C%0F3%8A%0A7%CCI%CA%0B%B4%05%00 = Achievement
        //%0B%0E75H%CE%B5%B0%05%00 = Intro
        //%0Bs%B7%2CK%F2%F0%B5%05%00 = Tools
        //%0B%CB%0D%CBO%0C%F7%2B%8E%0A%B4%B5%05%00 = Vehicle
        //%0B3%CA1Ht%0F%AA%8C%8CH%B6%05%00 = Withdraw
        //%0B%09%CF%A9J6%CA%29KJ%B7%B5%05%00 = Mission
        //%0B%CBu%2BN%0C%0F%CAHq%CF%29KJ%B7%B5%05%00 = Validation
        //%0B%F5%F0%2A%8B%CA%CD%29%8E%0A%B4%B5%05%00 = Profile

        //%0B3%C8%F1%07%00 = WIN
        //%0Bq%B5%0C%09%0A%B4%B5%05%00 = LOSE

        $key = [];

        for ($i = 0; $i < count(getter('request')); $i++) {
            $key += [decode_key(getter('request'), $i) => decode_value(getter('request'), $i)];
        }

        switch ($key['key']) {
            case 'Purchase':
                return $this->PurchaseEntry($request);
                break;
            case 'Achievement':
                # code...
                return $this->AchievementEntry($request);
                break;
            case 'Profile':
                # code...
                return $this->ProfileEntry($request);
                break;
            case 'Tools':
                # code...
                return $this->ToolsEntry($request);
                break;
            case 'Vehicle':
                # code...
                return $this->VehicleEntry($request);
                break;
            case 'Withdraw':
                # code...
                return $this->WithdrawEntry($request);
                break;
            case 'Mission':
                # code...
                return $this->MissionEntry($request);
                break;
            case 'Validation':
                # code...
                return $this->MissionValidation($request);
                break;
        }
    }
}
