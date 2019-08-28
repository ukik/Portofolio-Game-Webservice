<?php

namespace App\Model\Mutation\Record;

use Illuminate\Database\Eloquent\Model;

use App\Model\User\GetUser;

use RecordGetMissionStatus;

class GetMission extends Model
{

    use RecordGetMissionStatus;
    
    protected $table = 'mutation_record_mission';

    public $incrementing = false;
    
    protected $primaryKey = 'code_user';
    
    protected $guarded = [
      'id',
	    'uuid',
      'code_user',
      'code_mission',
      'code_tools_vehicle',
      'date',
      'key_level',
      'title',
      'key_title',
      'mode',
      'difficulty',
      'premium',
      'normal',
      'package',
      'key_package',
      'terrain',
      'tile',
      'cash',
      'coin',
      'score',
	    'done',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $filter = [
      'id',
	    'uuid',
      'code_user',
      'code_mission',
      'code_tools_vehicle',
      'date',
      'key_level',
      'title',
      'key_title',
      'mode',
      'difficulty',
      'premium',
      'normal',
      'package',
      'key_package',
      'terrain',
      'tile',
      'cash',
      'coin',
      'score',
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
		    'uuid'                => '',
        'code_user'           => '',
        'code_mission'        => '',
        'code_tools_vehicle'  => '',
        'date'                => '',
        'key_level'           => '',
        'title'               => '',
        'key_title'           => '',
        'mode'                => '',
        'difficulty'          => '',
        'premium'             => '',
        'normal'              => '',
        'package'             => '',
        'key_package'         => '',
        'terrain'             => '',
        'tile'                => '',
        'cash'                => '',
        'coin'                => '',
        'score'               => '',
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

    public function get_game()
    {
        return $this->hasOne(GetGame::class, 'code_mission', 'uuid');
    }    
}
