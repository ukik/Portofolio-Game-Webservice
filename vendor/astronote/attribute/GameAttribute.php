<?php

use App\Model\Library\PostSetting;

trait GameAttribute
{

    protected $library_setting;

    protected $game_complain_value;
    protected $game_life_value;
    protected $game_fuel_value;
    protected $game_time_value;
    protected $bonus_value;
    protected $bonus_cash_value;
    protected $bonus_coin_value;

    function __construct($attributes = array())
    {
        parent::__construct($attributes);

        $this->library_setting      = PostSetting::class;
        $this->game_complain_value  = $this->library_setting::whereAlias('game_complain_value')->value('value');
        $this->game_life_value      = $this->library_setting::whereAlias('game_life_value')->value('value');
        $this->game_fuel_value      = $this->library_setting::whereAlias('game_fuel_value')->value('value');
        $this->game_time_value      = $this->library_setting::whereAlias('game_time_value')->value('value');
        $this->bonus_value          = $this->library_setting::whereAlias('bonus_value')->value('value');
        $this->bonus_cash_value     = $this->library_setting::whereAlias('bonus_cash_value')->value('value');
        $this->bonus_coin_value     = $this->library_setting::whereAlias('bonus_coin_value')->value('value');
    }

    public function setTotalComplainAttribute($value = 0){
        $data = $this->game_complain_value * $value;
        return $this->attributes['total_complain'] = $data;
    }

    public function setTotalLifeAttribute($value = 0){
        $data = $this->game_life_value * $value;
        return $this->attributes['total_life'] = $data;
    }    

    public function setTotalFuelAttribute($value = 0){
        $data = $this->game_fuel_value * $value;
        return $this->attributes['total_fuel'] = $data;
    }  

    public function setTotalTimeAttribute($value = 0){
        $data = $this->game_time_value * $value;
        return $this->attributes['total_time'] = $data;
    }  

    public function setTotalBonusAttribute($value = 0){
        $data = $this->bonus_value * $value;
        return $this->attributes['total_bonus'] = $data;
    }      
    
    public function setCashAttribute($value = 0){
        $count = $this->bonus_cash_value * $value;
        setter('cash_in', $count);
        return $this->attributes['cash'] = $count;
    }
    
    public function setCoinAttribute($value = 0){
        $count = $this->bonus_coin_value * $value;
        setter('coin_in', $count);
        return $this->attributes['coin'] = $count;
    }    

    public function setScoreAttribute($value){

        $total_complain = $this->game_complain_value * $value['game_complain'];
        $total_life     = $this->game_life_value * $value['game_life'];
        $total_fuel     = $this->game_fuel_value * $value['game_fuel'];
        $total_time     = $this->game_time_value * $value['game_time'];
        $total_bonus    = $this->bonus_value * $value['bonus_obtained'];
   
        switch ($value['mode']) {
            case 'driver':
                $count = $total_complain + $total_life + $total_fuel + $total_time + $total_bonus;
                setter('score_in', $count);
                return $this->attributes['score'] = $count;
                break;
            case 'service':
                $count = $total_life + $total_time + $total_bonus;
                setter('score_in', $count);
                return $this->attributes['score'] = $count;
                break;
        }    
    }
}
