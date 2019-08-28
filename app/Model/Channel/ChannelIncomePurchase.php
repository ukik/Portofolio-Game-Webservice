<?php

namespace App\Model\Channel;

use Illuminate\Database\Eloquent\Model;

class ChannelIncomePurchase extends Model
{

    protected $table = 'channel_income_record_purchase';

    public $incrementing = false;
    
    protected $primaryKey = 'code_user';

    protected $guarded = [
      'code_user',
      'activity',
      'cash_price',
      'cash_in',
      'coin_price',
      'coin_in',
    ];

    protected $dates = ['deleted_at'];
    
    protected $filter = [
      'code_user',
      'activity',
      'cash_price',
      'cash_in',
      'coin_price',
      'coin_in',
    ];

    public static function initialize()
    {
      return [
        'code_user'   => '',
        'activity'    => '',
        'cash_price'  => '',
        'cash_in'     => '',
        'coin_price'  => '',
        'coin_in'     => '',
      ];
    }        

    public function get_user_profile()
    {
        return $this->hasOne(UserProfile::class, 'code_user');
    }    
}
