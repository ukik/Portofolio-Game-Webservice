<?php

namespace App\Model\Library;

use Illuminate\Database\Eloquent\Model;

use App\Model\Channel\ChannelHelperMutationToolsVehicle as ToolsVehicle;

use MissionAttribute;

use ContractMission;

use GameStatus;

class GetMission extends Model implements ContractMission
{
  
    use GameStatus;

    use MissionAttribute;

    protected $table = 'channel_helper_library_mission';

    protected $primaryKey = 'id';

    protected static $tools_vehicle_level = null;

    protected static $user = null;

    protected $guarded = [
      'code_mission',
      'title',
      'mode',
      'difficulty',
      'premium',
      'normal',
      'package',  // as player_select
      'cash',
      'coin',
      'score',
      'timer',
      'status',
      'created_at',
      'updated_at',
    ];

    protected $dates = [
      'deleted_at',
    ];

    protected $times = [
      'timer'
    ];

    protected $filter = [
      'id', 
      'title',
      'mode',
      'difficulty',
      'premium',
      'normal',
      'package',
      'cash',
      'coin',
      'timer',
      'score',
      'status',
      'created_at',
      'updated_at',
      'deleted_at',
    ];

    public static function initialize()
    {
      return [
        'title'       => '',
        'mode'        => '',
        'difficulty'  => '',
        'premium'     => '',
        'normal'      => '',
        'package'     => '',
        'cash'        => '',
        'coin'        => '',
        'timer'       => '',
        'score'       => '',
        'status'      => '',
        'created_at'  => '',
        'updated_at'  => '',
        'deleted_at'  => '',
      ];
    }        
  
}
