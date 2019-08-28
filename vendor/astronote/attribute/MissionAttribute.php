<?php

use App\Model\Channel\ChannelHelperMutationToolsVehicle as ToolsVehicle;
use App\Model\Library\PostSetting;

use DB;

trait MissionAttribute
{

    protected $library_setting;
    protected $terrain;

    function __construct($attributes = array())
    {
        parent::__construct($attributes);

        self::$user = getter('user');

        $this->mode;
        $this->difficulty;
        $this->premium;
        $this->normal;        

        // ?  boolean else return   
        // ?: boolean return        (pointer: false or true)
        // ?? boolean               (pointer: false or true)
        if(getter('client') == 'MissionAvailability'){
          $this->appends = [
            'game_setting',
            'time_setting',
            'time_waiting',
            'tools_vehicle',
          ];
          $this->hidden = [
            'cash',
            'coin',
            'score',
            'difficulty',
          ];
        }

        $this->library_setting = PostSetting::class;

    }

    public function ToolsVehicleLevel(){
        $toolsvehicle = ToolsVehicle::
            whereCodeUser(getter('user')->code_user)
            ->wherePackage($this->package)
            ->groupBy(['level'])
            ->pluck('level');

        self::$tools_vehicle_level = $toolsvehicle[rand(0, count($toolsvehicle) - 1)];
    }

    public function getGameSettingAttribute()
    {
        return [
            'user_name'             => ucwords(self::$user->name),
            'user_email'            => ucwords(self::$user->email),
            'user_phone'            => ucwords(self::$user->phone),

            'game_arena'            => ucwords($this->game_arena),
            'game_time'             => $this->game_time,            // driver & service
            'game_time_value'       => $this->game_time_value,
            'game_life_value'       => $this->game_life_value,
            'game_fuel_value'       => $this->game_fuel_value,
            'game_complain_value'   => $this->game_time_value,      // driver & service, di service = current_salah
            'game_duration'         => $this->game_duration,        // driver & service
            'game_complete_cash'    => $this->cash,                 // driver & service
            'game_complete_coin'    => $this->coin,                 // driver & service
            'game_complete_score'   => $this->score,                // driver & service
            'game_difficulty'       => ucwords($this->difficulty),

            'player_package'        => ucwords($this->package),
            'player_label'          => ucwords($this->player_label),
            'player_speed'          => $this->player_speed,
            'player_max_speed'      => $this->player_max_speed,
            'player_damage'         => $this->player_damage,
            'player_friction'       => $this->player_friction,

            'bonus_value'           => $this->bonus_value,          // driver & service, di service = current_benar

            'terrain'               => $this->terrain,

        ];
    }

    public function getToolsVehicleAttribute ()
    {
        $this->ToolsVehicleLevel();

        return $tools_vehicle = ToolsVehicle::
            select(
                DB::raw(
                    '
                    *,
                    CASE 
                        WHEN sum(level) = (1) THEN 1
                        WHEN sum(level) = (1+2) THEN 2
                        WHEN sum(level) = (1+2+3) THEN 3
                        ELSE max(level)
                    END AS level
                    '
                )
            )
            ->whereCodeUser(getter('user')->code_user) 
            ->whereLevel(self::$tools_vehicle_level)
            ->wherePackage($this->package)
            ->select([
                'code_tools_vehicle',
                'level',
                'health',
                'fuel',
                'package',
            ])
            ->groupBy([
                'code_user',
                'package',
            ])->first(); 
    }

    public function getTimeSettingAttribute()
    {
      
        $premium = getter('premium');
        
        $server_datetime = \Carbon\Carbon::
            now(new \DateTimeZone('Asia/Makassar'))
            ->addHour(0)->format('H:m:s');

        if($premium){
            return date("H:m:s", strtotime($this->timer)) >= $server_datetime;
        }

        return true;
    }
  
    public function getTimeWaitingAttribute()
    {
        
        $premium = getter('premium');
  
        if($premium){
  
            $server_datetime = \Carbon\Carbon::
                now(new \DateTimeZone('Asia/Makassar'))
                ->addHour(0)->format('H:m:s'); 

            //$server_datetime = \Carbon\Carbon::now();    
            return round(Calculation_Now($this->timer, $server_datetime));
        }

        return 0;
    }

    public function getGameArenaAttribute()
    {
        switch ($this->package) {
            case 'fashion':

                $nama_arena = array_values([
                    'Fashion Cewek', 'Fashion Cowok'
                ])[mt_rand(0,1)];

                $arena = (string) $nama_arena;

                $this->terrain = $nama_arena;

                return $arena;        

                /*
                case 'cleaner':
                    return array_values([
                        //'Cuci Mobil_1', 'Cuci Mobil_2', 'Cuci Mobil_3', 'Cuci Mobil_4', 'Cuci Mobil_5',
                        //'Cuci Motor_1', 'Cuci Motor_2', 'Cuci Motor_3', 'Cuci Motor_4', 'Cuci Motor_5',
                        //'Cuci Sepeda_1', 'Cuci Sepeda_2', 'Cuci Sepeda_3', 'Cuci Sepeda_4', 'Cuci Sepeda_5',
                    ])[mt_rand(0,14)];
                */

                break;

            case 'cleaner':
            case 'washer':

                /*
                return array_values([
                    'Cuci_Anjing_1', 'Cuci Anjing_2', 'Cuci Anjing_3', 'Cuci Anjing_4', 'Cuci Anjing_5',
                    'Cuci_Kucing_1', 'Cuci Kucing_2', 'Cuci Kucing_3', 'Cuci Kucing_4', 'Cuci Kucing_5',
                    'Cuci_Kelinci_1', 'Cuci Kelinci_2', 'Cuci Kelinci_3', 'Cuci Kelinci_4', 'Cuci Kelinci_5',
                    //'Cuci Kuda_1', 'Cuci Kuda_2', 'Cuci Kuda_3', 'Cuci Kuda_4', 'Cuci Kuda_5',
                    //'Cuci Sapi_1', 'Cuci Sapi_2', 'Cuci Sapi_3', 'Cuci Sapi_4', 'Cuci Sapi_5',
                ])[mt_rand(0,14)];
                */

                $nama_arena = array_values([
                    'Anjing', 'Kucing', 'Kelinci',
                ])[mt_rand(0,2)];

                $tipe_arena = array_values([
                    ' 1', ' 2', ' 3', ' 4', ' 5',
                ])[mt_rand(0,4)];

                $arena = (string) $nama_arena.$tipe_arena;

                $this->terrain = $arena;

                return $arena;            
                
                break;

            case 'service':
                
                $nama_arena = array_values([
                    'Dapur', 'Kamar Anak', 'Ruang Tamu',
                ])[mt_rand(0,2)];

                $arena = (string) $nama_arena;

                $this->terrain = $nama_arena;

                return $arena;                

                break;

            case 'motorcycle':
            case 'motorbox':
            case 'mobil':
            case 'pickup':

                $nama_arena = array_values([
                    'Jembatan', 'Hutan', 'Pantai', 'Perumahan', 'Sawah',
                ])[mt_rand(0,4)];

                $tipe_arena = array_values([
                    '_1', '_2', '_3', '_4', '_5',
                ])[mt_rand(0,4)];

                $arena = (string) $nama_arena.$tipe_arena;

                $this->terrain = $nama_arena;

                return $arena;

                // return array_values([
                    // 'Gedung_1', 'Hutan_1', 'Pantai_1', 'Perumahan_1', 'Sawah_1',
                    // 'Gedung_2', 'Hutan_2', 'Pantai_2', 'Perumahan_2', 'Sawah_2',
                    // 'Gedung_3', 'Hutan_3', 'Pantai_3', 'Perumahan_3', 'Sawah_3',
                    // 'Gedung_4', 'Hutan_4', 'Pantai_4', 'Perumahan_4', 'Sawah_4',
                    // 'Gedung_5', 'Hutan_5', 'Pantai_5', 'Perumahan_5', 'Sawah_5',
                // ])[mt_rand(0,24)];

                break;
        }
    }    

    public function getGameTimeAttribute()
    {
        switch (($this->difficulty)) {
            case 'Mudah':
                return $this->library_setting::whereAlias('game_time_easy')->value('value');
                //rand(50, 65);
                break;
            case 'Sedang':
                return $this->library_setting::whereAlias('game_time_medium')->value('value');
                //rand(40, 55);
                break;
            case 'Sulit':
                return $this->library_setting::whereAlias('game_time_hard')->value('value');
                //rand(30, 45);
                break;
        }
    }

    public function getGameTimeValueAttribute()
    {
        return $this->library_setting::whereAlias('game_time_value')->value('value');
    }

    public function getGameLifeValueAttribute()
    {
        return $this->library_setting::whereAlias('game_life_value')->value('value');
    }    

    public function getGameFuelValueAttribute()
    {
        return $this->library_setting::whereAlias('game_fuel_value')->value('value');
    }    

    public function getGameComplainValueAttribute()
    {
        return $this->library_setting::whereAlias('game_complain_value')->value('value');
    }            

    public function getBonusValueAttribute()
    {
        return $this->library_setting::whereAlias('bonus_value')->value('value');
    }            

    public function getGameDurationAttribute()
    {
        switch (($this->difficulty)) {
            case 'Mudah':
                return $this->library_setting::whereAlias('game_duration_easy')->value('value');
                break;
            case 'Sedang':
                return $this->library_setting::whereAlias('game_duration_medium')->value('value');
                break;
            case 'Sulit':
                return $this->library_setting::whereAlias('game_duration_hard')->value('value');
                break;
        }
    }

    public function getPlayerLabelAttribute()
    {
      switch ($this->package) {
        case 'fashion':
        case 'cleaner':
        case 'washer':
        case 'service':
            //return "belum dikerjakan";
            return 'Graphic_'.ucwords($this->package).'_Player_'.self::$tools_vehicle_level;
            break;
        case 'motorcycle':
        case 'motorbox':
        case 'mobil':
        case 'pickup':
            return 'Graphic_'.ucwords($this->package).'_Player_'.self::$tools_vehicle_level;
            break;
      }
    }

    public function getPlayerSpeedAttribute()
    {
        switch (self::$tools_vehicle_level) {
            case 1:
                return $this->library_setting::whereAlias('player_speed_level_1')->value('value');
                break;
            case 2:
                return $this->library_setting::whereAlias('player_speed_level_2')->value('value');
                break;
            case 3:
                return $this->library_setting::whereAlias('player_speed_level_3')->value('value');
                break;
        }
    }

    public function getPlayerMaxSpeedAttribute()
    {
        switch (self::$tools_vehicle_level) {
            case 1:
                return $this->library_setting::whereAlias('player_max_speed_level_1')->value('value');
                break;
            case 2:
                return $this->library_setting::whereAlias('player_max_speed_level_2')->value('value');
                break;
            case 3:
                return $this->library_setting::whereAlias('player_max_speed_level_3')->value('value');
                break;
        }
    }    

    public function getPlayerDamageAttribute()
    {
        switch (self::$tools_vehicle_level) {
            case 1:
                return $this->library_setting::whereAlias('player_damage_level_1')->value('value');
                break;
            case 2:
                return $this->library_setting::whereAlias('player_damage_level_2')->value('value');
                break;
            case 3:
                return $this->library_setting::whereAlias('player_damage_level_3')->value('value');
                break;
        }
    }  


    public function getPlayerFrictionAttribute()
    {
        switch (self::$tools_vehicle_level) {
            case 1:
                return $this->library_setting::whereAlias('player_friction_level_1')->value('value');
                break;
            case 2:
                return $this->library_setting::whereAlias('player_friction_level_2')->value('value');
                break;
            case 3:
                return $this->library_setting::whereAlias('player_friction_level_3')->value('value');
                break;
        }
    }  

    public function getModeAttribute($value)
    {
        switch ($value) {
            case 'driver':
                $value = 'Kendaraan';
                break;
            case 'service':
                $value = 'Jasa';
                break;
        }
        return $this->mode = ucwords($value);
    }

    public function getDifficultyAttribute()
    {
        $difficulty = $this->attributes['difficulty'];
        switch ($difficulty) {
            case 'easy':
                $difficulty = 'Mudah';
                break;
            case 'medium':
                $difficulty = 'Sedang';
                break;
            case 'hard':
                $difficulty = 'Sulit';
                break;
        }
        return $difficulty; //ucwords();
    }
    
    public function getPremiumAttribute()
    {
        return ucwords($this->attributes['premium']);
    }

    public function getNormalAttribute()
    {
        return ucwords($this->attributes['normal']);
    }

    public function setCashAttribute($value = 0){

        return $this->attributes['cash'] = $this->library_setting::whereAlias('bonus_value')->value('value') * $value;
    }     

    public function setCoinAttribute($value = 0){

        return $this->attributes['coin'] = $this->library_setting::whereAlias('bonus_value')->value('value') * $value;
    }     

    public function setScoreAttribute($value = 0){

        return $this->attributes['score'] = $this->library_setting::whereAlias('bonus_value')->value('value') * $value;
    }     

}