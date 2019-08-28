<?php

namespace App\Model\Channel;

use Illuminate\Database\Eloquent\Model;


class ChannelIncomeMission extends Model
{ 

    protected $table = 'channel_income_record_mission';

    public $incrementing = false;
    
    protected $primaryKey = 'code_user';

    protected $guarded = [
      'code_user',
      'activity',
      'cash_in',
      'coin_in',
      'score_in'
    ];

    protected $dates = ['deleted_at'];
    
    protected $filter = [
      'code_user',
      'activity',
      'cash_in',
      'coin_in',
      'score_in'       
    ];

    public static function initialize()
    {
      return [
        'code_user' => '',
        'activity'  => '',
        'cash_in'   => '',
        'coin_in'   => '',
        'score_in'  => ''
      ];
    }        

    public function get_user_profile()
    {
        return $this->hasOne(UserProfile::class, 'code_user');
    }    
}
