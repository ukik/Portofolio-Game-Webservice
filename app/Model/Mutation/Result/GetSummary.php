<?php

namespace App\Model\Mutation\Result;

use Illuminate\Database\Eloquent\Model;

use App\Model\User\GetUser;

use GameStatus;

use SummaryAttribute;

use ContractSummary;

class GetSummary extends Model implements ContractSummary
{

    use SummaryAttribute;

    use GameStatus;

    protected $table = 'user_summary';

    public $incrementing = false;
    
    protected $primaryKey = 'code_user';

    protected $guarded = [
      'id',
      'code_summary',
      'code_user',
      'activity',
      'premium',
      'normal',
      'cash_in',
      'cash_out',
      'coin_in',
      'coin_out',
      'score_in',
      'bonus_in',
      'score_tournament',      
      'tools_vehicle',
      'created_at',
      'updated_at', 
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id',
      'code_summary',
      'code_user',
      'activity',
      'premium',
      'normal',
      'cash_in',
      'cash_out',
      'coin_in',
      'coin_out',
      'score_in',
      'bonus_in',
      'score_tournament',      
      'tools_vehicle',
      'created_at',
      'updated_at',
      'deleted_at',
      
      'get_user_profile.id',
      'get_user_profile.code_user',
      'get_user_profile.name',
      'get_user_profile.email',
      'get_user_profile.address',
      'get_user_profile.phone',
      'get_user_profile.scope',
      'get_user_profile.status',
      'get_user_profile.created_at',
      'get_user_profile.updated_at',            
    ];

    public static function initialize()
    {
      return [
        'id'          => '',
        'code_summary' => '',
        'code_user'   => '',
        'activity'    => '',
        'premium'     => '',
        'normal'      => '',
        'cash_in'     => '',
        'cash_out'    => '',
        'coin_in'     => '',
        'coin_out'    => '',
        'score_in'    => '',
        'bonus_in'    => '',
        'score_tournament' => '',        
        'tools_vehicle' => '',
        'created_at'  => '',
        'updated_at'  => '',
        'deleted_at'  => '',     

        'get_user_profile.id'         => '',
        'get_user_profile.code_user'  => '',
        'get_user_profile.name'       => '',
        'get_user_profile.email'      => '',
        'get_user_profile.address'    => '',
        'get_user_profile.phone'      => '',
        'get_user_profile.scope'      => '',
        'get_user_profile.status'     => '',
        'get_user_profile.created_at' => '',
        'get_user_profile.updated_at' => '',           
      ];
    }        

    protected $hidden = [
      'created_at',
      'updated_at',
      'deleted_at'    
    ];

    public function get_user_profile()
    {
        return $this
          ->hasOne(GetUser::class, 'code_user');
    }    

}
