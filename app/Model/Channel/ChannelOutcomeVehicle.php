<?php

namespace App\Model\Channel;

use Illuminate\Database\Eloquent\Model;

class ChannelOutcomeVehicle extends Model
{

    protected $table = 'channel_outcome_record_vehicle';

    public $incrementing = false;
    
    protected $primaryKey = 'code_user';

    protected $guarded = [
      'code_user',
      'activity',
      'cash_out',
      'coin_out',
    ];

    protected $dates = ['deleted_at'];
    
    protected $filter = [
      'code_user',
      'activity',
      'cash_out',
      'coin_out',
    ];

    public static function initialize()
    {
      return [
        'code_user' => '',
        'activity'  => '',
        'cash_out'  => '',
        'coin_out'  => '',
      ];
    }        

    public function get_user_profile()
    {
        return $this->hasOne(UserProfile::class, 'code_user');
    }    
}
