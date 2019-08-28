<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

use App\Model\User\GetUser;

use GameStatus;

class GetGame extends Model
{
    
    use GameStatus;

    protected $table = 'mutation_record_game';

    public $incrementing = false; // Indicates if the IDs are auto-incrementing.
    
    protected $primaryKey = null; // disable primary key
    
    protected $guarded = [
      'id',
      'code_user',
      'code_game',
      'code_mission',
	    'code_tools_vehicle',
      'title',
      'premium',
      'normal',
      // 'mode',
      'total_complain',
      'total_life',
      'total_fuel',
      'total_time',
      'total_bonus',
      'cash',
      'score',
      'coin',
      'done',      
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id',
      'code_user',
      'code_game',
      'code_mission',
	    'code_tools_vehicle',
      'title',
      'premium',
      'normal',
      // 'mode',
      'total_complain',
      'total_life',
      'total_fuel',
      'total_time',
      'total_bonus',
      'cash',
      'score',
      'coin',
      'done',      
      'status',
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
        'id'                  => '',
        'code_user'           => '',
        'code_game'           => '',
        'code_mission'        => '',
        'code_tools_vehicle'  => '',
        'title'               => '',
        'premium'             => '',
        'normal'              => '',
        // 'mode'                => '',
        'total_complain'      => '',
        'total_life'          => '',
        'total_fuel'          => '',
        'total_time'          => '',
        'total_bonus'         => '',
        'cash'                => '',
        'score'               => '',
        'coin'                => '',
        'done'                => '',      
        'status'              => '',
        'created_at'          => '',
        'updated_at'          => '',  
        'deleted_at'          => '',              

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

    public function get_user_profile()
    {
        return $this->hasOne(GetUser::class, 'code_user');
    }

    public function get_mission()
    {
        return $this->belongsTo(GetMission::class, 'code_mission', 'uuid');
    }
}
